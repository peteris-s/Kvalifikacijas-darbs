<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockIssueController extends Controller
{
    /**
     * Parāda preču izsniegšanas vēsturi.
     */
    public function index()
    {
        $stockIssues = StockIssue::with([
                'product',
                'user',
            ])
            ->orderByDesc('issued_at')
            ->get();

        return view(
            'stock-issues.index',
            compact('stockIssues')
        );
    }


    /**
     * Parāda jaunas preču izsniegšanas formu.
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
            'stock-issues.create',
            compact('products')
        );
    }


    /**
     * Reģistrē vienu vai vairākas preces vienā izsniegšanā.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => [
                'required',
                'string',
                'max:255',
            ],

            'products' => [
                'required',
                'array',
                'min:1',
            ],

            'products.*.product_id' => [
                'required',
                'integer',
                'distinct',
                'exists:products,id',
            ],

            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);


        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | Sagatavojam preces
            |--------------------------------------------------------------------------
            |
            | Sakārtojam pēc ID, lai preces vienmēr tiktu bloķētas
            | vienādā secībā.
            |
            */

            $requestedProducts = collect($validated['products'])
                ->sortBy('product_id')
                ->values();


            $productIds = $requestedProducts
                ->pluck('product_id')
                ->map(fn ($id) => (int) $id)
                ->all();


            /*
            |--------------------------------------------------------------------------
            | Bloķējam visas nepieciešamās preces
            |--------------------------------------------------------------------------
            |
            | lockForUpdate novērš situāciju, kur divi darbinieki
            | vienlaicīgi mēģina izsniegt vienu un to pašu preci.
            |
            */

            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');


            /*
            |--------------------------------------------------------------------------
            | Pārbaudām VISAS preces pirms atlikumu maiņas
            |--------------------------------------------------------------------------
            |
            | Ja kaut vienai precei nav pietiekams atlikums,
            | tiek izmests validation error un visa transakcija
            | tiek atcelta.
            |
            */

            foreach ($requestedProducts as $index => $requestedProduct) {

                $productId =
                    (int) $requestedProduct['product_id'];

                $quantity =
                    (int) $requestedProduct['quantity'];


                $product = $products->get($productId);


                if (!$product) {

                    throw ValidationException::withMessages([
                        "products.$index.product_id" =>
                            'Izvēlētā prece netika atrasta.',
                    ]);
                }


                if ($product->quantity < $quantity) {

                    throw ValidationException::withMessages([
                        "products.$index.quantity" =>
                            'Precei "' .
                            $product->name .
                            '" noliktavā nav pietiekams daudzums. Pieejams: ' .
                            $product->quantity .
                            ' gab.',
                    ]);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Reģistrējam izsniegšanu
            |--------------------------------------------------------------------------
            |
            | Tikai pēc tam, kad visas preces ir pārbaudītas,
            | izveidojam izsniegšanas ierakstus un samazinām atlikumus.
            |
            */

            foreach ($requestedProducts as $requestedProduct) {

                $productId =
                    (int) $requestedProduct['product_id'];

                $quantity =
                    (int) $requestedProduct['quantity'];


                $product = $products->get($productId);


                StockIssue::create([
                    'order_number' =>
                        $validated['order_number'],

                    'product_id' =>
                        $product->id,

                    'user_id' =>
                        auth()->id(),

                    'quantity' =>
                        $quantity,

                    'notes' =>
                        $validated['notes'] ?? null,

                    'issued_at' =>
                        now(),
                ]);


                $product->decrement(
                    'quantity',
                    $quantity
                );
            }

        });


        return redirect()
            ->route('stock-issues.index')
            ->with(
                'success',
                'Preču izsniegšana veiksmīgi reģistrēta.'
            );
    }
}