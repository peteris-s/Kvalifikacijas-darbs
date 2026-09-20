<?php

namespace App\Http\Controllers;

use App\Models\Product;

class PurchasePlanningController extends Controller
{
    public function index()
    {
        /*
         * Iepirkumu sarakstā iekļaujam tikai tās preces,
         * kuru pašreizējais atlikums ir zem minimālā atlikuma.
         *
         * Piemērs:
         * quantity = 4
         * minimum_quantity = 10
         * ieteicams pasūtīt = 6
         */
        $products = Product::with('category')
            ->whereColumn('quantity', '<', 'minimum_quantity')
            ->orderBy('quantity')
            ->get();

        return view(
            'purchase-planning.index',
            compact('products')
        );
    }
}