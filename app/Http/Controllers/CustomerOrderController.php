<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem;
use App\Models\Product;
use App\Models\StockIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = CustomerOrder::with(['items.product.category'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('ordered_at')
            ->orderByDesc('id')
            ->paginate(15);

        $pendingCount = CustomerOrder::where('status', 'pending')
            ->count();

        $issuedCount = CustomerOrder::where('status', 'issued')
            ->count();

        return view('customer-orders.index', compact(
            'orders',
            'pendingCount',
            'issuedCount'
        ));
    }

    public function create()
    {
        $products = Product::with([
            'category',
            'warehouseLocation.parent'
        ])
            ->orderBy('name')
            ->get();

        return view('customer-orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => [
                'required',
                'string',
                'max:255',
                'unique:customer_orders,order_number'
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'products' => [
                'required',
                'array',
                'min:1'
            ],
            'products.*.product_id' => [
                'required',
                'integer',
                'exists:products,id',
                'distinct'
            ],
            'products.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],
        ]);

        DB::transaction(function () use ($validated) {

            // Lock products in a consistent ID order.
            $productIds = collect($validated['products'])
                ->pluck('product_id')
                ->map(fn ($id) => (int) $id)
                ->sort()
                ->values();

            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Calculate quantities already reserved by pending orders.
            $reserved = CustomerOrderItem::query()
                ->select('customer_order_items.product_id')
                ->selectRaw(
                    'SUM(customer_order_items.quantity) AS reserved_quantity'
                )
                ->join(
                    'customer_orders',
                    'customer_orders.id',
                    '=',
                    'customer_order_items.customer_order_id'
                )
                ->where('customer_orders.status', 'pending')
                ->whereIn('customer_order_items.product_id', $productIds)
                ->groupBy('customer_order_items.product_id')
                ->pluck(
                    'reserved_quantity',
                    'customer_order_items.product_id'
                );

            foreach ($validated['products'] as $index => $item) {

                $product = $products->get(
                    (int) $item['product_id']
                );

                if (!$product) {
                    throw ValidationException::withMessages([
                        "products.$index.product_id" =>
                            'Izvēlētā prece vairs nav pieejama.',
                    ]);
                }

                $reservedQuantity = (int) (
                    $reserved->get($product->id) ?? 0
                );

                $availableQuantity = max(
                    0,
                    (int) $product->quantity - $reservedQuantity
                );

                if (
                    (int) $item['quantity'] > $availableQuantity
                ) {
                    throw ValidationException::withMessages([
                        "products.$index.quantity" =>
                            'Nepietiekams brīvais atlikums precei "' .
                            $product->name .
                            '". Noliktavā: ' .
                            $product->quantity .
                            ' gab., rezervēti: ' .
                            $reservedQuantity .
                            ' gab., brīvi: ' .
                            $availableQuantity .
                            ' gab.',
                    ]);
                }
            }

            // Create the pending order.
            $order = CustomerOrder::create([
                'order_number' => $validated['order_number'],
                'status' => 'pending',
                'ordered_at' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);

            // Save all ordered products.
            foreach ($validated['products'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

        }, 3);

        return redirect()
            ->route('customer-orders.index')
            ->with(
                'success',
                'Pasūtījums veiksmīgi reģistrēts. Preces ir rezervētas līdz izsniegšanai.'
            );
    }

    public function issue(CustomerOrder $customerOrder)
    {
        DB::transaction(function () use ($customerOrder) {

            // Prevent the same order from being issued twice.
            $order = CustomerOrder::whereKey(
                $customerOrder->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            if (!$order->isPending()) {
                throw ValidationException::withMessages([
                    'order' =>
                        'Šis pasūtījums jau ir izsniegts.',
                ]);
            }

            $order->load('items');

            $productIds = $order->items
                ->pluck('product_id')
                ->sort()
                ->values();

            // Lock products in ascending ID order.
            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Validate all quantities before issuing anything.
            foreach ($order->items as $item) {

                $product = $products->get(
                    $item->product_id
                );

                if (!$product) {
                    throw ValidationException::withMessages([
                        'order' =>
                            'Viena no pasūtījuma precēm vairs nav pieejama.',
                    ]);
                }

                if (
                    $product->quantity < $item->quantity
                ) {
                    throw ValidationException::withMessages([
                        'order' =>
                            'Nepietiekams atlikums precei "' .
                            $product->name .
                            '". Pieejams: ' .
                            $product->quantity .
                            ' gab., nepieciešams: ' .
                            $item->quantity .
                            ' gab.',
                    ]);
                }
            }

            // Issue all products and update warehouse stock.
            foreach ($order->items as $item) {

                $product = $products->get(
                    $item->product_id
                );

                StockIssue::create([
                    'order_number' => $order->order_number,
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'quantity' => $item->quantity,
                    'notes' =>
                        'Izsniegts no pasūtījumu saraksta.',
                    'issued_at' => now(),
                ]);

                $product->decrement(
                    'quantity',
                    $item->quantity
                );
            }

            // Mark the order as issued.
            $order->update([
                'status' => 'issued'
            ]);

        }, 3);

        return redirect()
            ->route('customer-orders.index')
            ->with(
                'success',
                'Pasūtījums veiksmīgi izsniegts un noliktavas atlikumi atjaunināti.'
            );
    }
}
