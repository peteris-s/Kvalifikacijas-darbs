<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem;
use App\Models\Product;
use App\Models\StockIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockIssueController extends Controller
{
    /** Parāda izsniegšanas vēsturi, 15 pasūtījumus vienā lapā. */
    public function index()
    {
        // Lapošana pēc pasūtījuma numura, nevis atsevišķām preču rindām.
        $orderPages = StockIssue::query()
            ->select('order_number')
            ->selectRaw('MAX(issued_at) AS latest_issued_at')
            ->selectRaw('MAX(id) AS latest_id')
            ->groupBy('order_number')
            ->orderByDesc('latest_issued_at')
            ->orderByDesc('latest_id')
            ->paginate(15);

        $orderNumbers = $orderPages->getCollection()->pluck('order_number');

        $issuesByOrder = StockIssue::with(['product.category', 'user'])
            ->whereIn('order_number', $orderNumbers->all())
            ->orderByDesc('issued_at')
            ->orderByDesc('id')
            ->get()
            ->groupBy('order_number');

        // Saglabājam tādu pašu secību kā lapotajā pasūtījumu sarakstā.
        $groupedIssues = $orderNumbers->mapWithKeys(
            fn ($number) => [$number => $issuesByOrder->get($number, collect())]
        );

        // Statistika par VISU vēsturi, nevis tikai atvērto lapu.
        $totalOrders = $orderPages->total();
        $totalPositions = StockIssue::count();
        $totalItems = StockIssue::sum('quantity');

        return view('stock-issues.index', compact(
            'groupedIssues',
            'orderPages',
            'totalOrders',
            'totalPositions',
            'totalItems'
        ));
    }

    /** Parāda jaunas preču izsniegšanas formu. */
    public function create()
    {
        $products = Product::with(['category', 'warehouseLocation.parent'])
            ->orderBy('name')
            ->get();

        $reservedQuantities = CustomerOrderItem::query()
            ->select('customer_order_items.product_id')
            ->selectRaw('SUM(customer_order_items.quantity) AS reserved_quantity')
            ->join(
                'customer_orders',
                'customer_orders.id',
                '=',
                'customer_order_items.customer_order_id'
            )
            ->where('customer_orders.status', 'pending')
            ->groupBy('customer_order_items.product_id')
            ->pluck('reserved_quantity', 'customer_order_items.product_id');

        return view('stock-issues.create', compact(
            'products',
            'reservedQuantities'
        ));
    }

    /** Reģistrē manuālu preču izsniegšanu no nerezervētā atlikuma. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => ['required', 'string', 'max:255'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => [
                'required',
                'integer',
                'distinct',
                'exists:products,id'
            ],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated) {
            // Pasūtījumu sadaļā izveidotie pasūtījumi jāizsniedz tikai tur.
            if (CustomerOrder::where(
                'order_number',
                $validated['order_number']
            )->exists()) {
                throw ValidationException::withMessages([
                    'order_number' =>
                        'Šāds pasūtījuma numurs jau pastāv. ' .
                        'Izsniedziet to sadaļā "Pasūtījumi".',
                ]);
            }

            $requestedProducts = collect($validated['products'])
                ->sortBy(fn ($item) => (int) $item['product_id'])
                ->values();

            $productIds = $requestedProducts
                ->pluck('product_id')
                ->map(fn ($id) => (int) $id)
                ->all();

            // Bloķējam produktus ID secībā.
            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Rezervācijas aprēķinām pēc produktu bloķēšanas.
            $reserved = CustomerOrderItem::query()
                ->select('customer_order_items.product_id')
                ->selectRaw('SUM(customer_order_items.quantity) AS reserved_quantity')
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

            // Pārbaudām visas rindas pirms saglabāšanas.
            foreach ($requestedProducts as $index => $requestedProduct) {
                $productId = (int) $requestedProduct['product_id'];
                $quantity = (int) $requestedProduct['quantity'];
                $product = $products->get($productId);

                if (!$product) {
                    throw ValidationException::withMessages([
                        "products.$index.product_id" =>
                            'Izvēlētā prece netika atrasta.',
                    ]);
                }

                $reservedQuantity = (int) ($reserved->get($productId) ?? 0);
                $availableQuantity = max(
                    0,
                    (int) $product->quantity - $reservedQuantity
                );

                if ($quantity > $availableQuantity) {
                    throw ValidationException::withMessages([
                        "products.$index.quantity" =>
                            'Nepietiekams brīvais atlikums precei "' .
                            $product->name .
                            '". Noliktavā: ' . $product->quantity .
                            ' gab., rezervēti: ' . $reservedQuantity .
                            ' gab., brīvi: ' . $availableQuantity . ' gab.',
                    ]);
                }
            }

            foreach ($requestedProducts as $requestedProduct) {
                $productId = (int) $requestedProduct['product_id'];
                $quantity = (int) $requestedProduct['quantity'];
                $product = $products->get($productId);

                StockIssue::create([
                    'order_number' => $validated['order_number'],
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'quantity' => $quantity,
                    'notes' => $validated['notes'] ?? null,
                    'issued_at' => now(),
                ]);

                $product->decrement('quantity', $quantity);
            }
        }, 3);

        return redirect()
            ->route('stock-issues.index')
            ->with(
                'success',
                'Preču izsniegšana veiksmīgi reģistrēta.'
            );
    }
}
