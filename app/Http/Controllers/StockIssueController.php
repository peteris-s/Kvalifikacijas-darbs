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
     * Reģistrē preču izsniegšanu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => [
                'required',
                'string',
                'max:255',
            ],

            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'quantity' => [
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
             * Bloķējam preci transakcijas laikā,
             * lai divi darbinieki vienlaicīgi nevarētu
             * izsniegt vairāk preču nekā ir noliktavā.
             */
            $product = Product::where(
                'id',
                $validated['product_id']
            )
                ->lockForUpdate()
                ->firstOrFail();


            /*
             * Pārbaudām, vai noliktavā ir
             * pietiekams daudzums.
             */
            if ($product->quantity < $validated['quantity']) {

                throw ValidationException::withMessages([
                    'quantity' =>
                        'Noliktavā nav pietiekams preces daudzums. Pieejams: '
                        . $product->quantity
                        . ' gab.',
                ]);
            }


            /*
             * Saglabājam izsniegšanas vēsturi.
             */
            StockIssue::create([
                'order_number' => $validated['order_number'],
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'quantity' => $validated['quantity'],
                'notes' => $validated['notes'] ?? null,
                'issued_at' => now(),
            ]);


            /*
             * Samazinām preces atlikumu.
             */
            $product->decrement(
                'quantity',
                $validated['quantity']
            );
        });


        return redirect()
            ->route('stock-issues.index')
            ->with(
                'success',
                'Preču izsniegšana veiksmīgi reģistrēta.'
            );
    }
}