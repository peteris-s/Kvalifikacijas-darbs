<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Models\Product;
use App\Models\StockIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CustomerOrderController extends Controller
{
    /**
     * Parāda visus pasūtījumus.
     */
    public function index()
    {
        $orders = CustomerOrder::with([
                'items.product.category',
            ])
            ->orderByRaw("
                CASE
                    WHEN status = 'pending' THEN 0
                    ELSE 1
                END
            ")
            ->orderByDesc('ordered_at')
            ->get();

        return view(
            'customer-orders.index',
            compact('orders')
        );
    }


    /**
     * Parāda jauna pasūtījuma izveides formu.
     */
    public function create()
    {
        $products = Product::with([
                'category',
                'warehouseLocation.parent',
            ])
            ->orderBy('name')
            ->get();

        return view(
            'customer-orders.create',
            compact('products')
        );
    }


    /**
     * Saglabā jaunu pasūtījumu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => [
                'required',
                'string',
                'max:255',
                'unique:customer_orders,order_number',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'products' => [
                'required',
                'array',
                'min:1',
            ],

            'products.*.product_id' => [
                'required',
                'integer',
                'exists:products,id',
                'distinct',
            ],

            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);


        DB::transaction(function () use ($validated) {

            $order = CustomerOrder::create([
                'order_number' => $validated['order_number'],
                'status' => 'pending',
                'ordered_at' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);


            foreach ($validated['products'] as $productData) {

                $order->items()->create([
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                ]);
            }
        });


        return redirect()
            ->route('customer-orders.index')
            ->with(
                'success',
                'Pasūtījums veiksmīgi reģistrēts un gaida izsniegšanu.'
            );
    }


    /**
     * Izsniedz visu pasūtījumu.
     */
    public function issue(CustomerOrder $customerOrder)
    {
        DB::transaction(function () use ($customerOrder) {

            /*
             * Bloķējam pašu pasūtījumu, lai divi
             * darbinieki nevarētu to izsniegt vienlaicīgi.
             */
            $order = CustomerOrder::where(
                'id',
                $customerOrder->id
            )
                ->lockForUpdate()
                ->firstOrFail();


            /*
             * Ja pasūtījums jau izsniegts,
             * atkārtota izsniegšana nav atļauta.
             */
            if (!$order->isPending()) {
                throw ValidationException::withMessages([
                    'order' => 'Šis pasūtījums jau ir izsniegts.',
                ]);
            }


            $order->load('items');


            /*
             * Sakārtojam produktu ID.
             * Tas palīdz samazināt DB bloķēšanas konfliktu risku.
             */
            $productIds = $order->items
                ->pluck('product_id')
                ->sort()
                ->values();


            /*
             * Bloķējam visas pasūtījuma preces.
             */
            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');


            /*
             * PIRMS jebkādas atlikumu samazināšanas
             * pārbaudām visas preces.
             */
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


                if ($product->quantity < $item->quantity) {

                    throw ValidationException::withMessages([
                        'order' =>
                            'Nepietiekams atlikums precei "'
                            . $product->name
                            . '". Pieejams: '
                            . $product->quantity
                            . ' gab., nepieciešams: '
                            . $item->quantity
                            . ' gab.',
                    ]);
                }
            }


            /*
             * Visām precēm atlikums ir pietiekams.
             * Tagad varam izsniegt visu pasūtījumu.
             */
            foreach ($order->items as $item) {

                $product = $products->get(
                    $item->product_id
                );


                /*
                 * Izveidojam izsniegšanas vēstures ierakstu.
                 */
                StockIssue::create([
                    'order_number' => $order->order_number,
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'quantity' => $item->quantity,
                    'notes' => 'Izsniegts no pasūtījumu saraksta.',
                    'issued_at' => now(),
                ]);


                /*
                 * Samazinām noliktavas atlikumu.
                 */
                $product->decrement(
                    'quantity',
                    $item->quantity
                );
            }


            /*
             * Pasūtījums pilnībā izsniegts.
             */
            $order->update([
                'status' => 'issued',
            ]);
        });


        return redirect()
            ->route('customer-orders.index')
            ->with(
                'success',
                'Pasūtījums veiksmīgi izsniegts un noliktavas atlikumi atjaunināti.'
            );
    }
}