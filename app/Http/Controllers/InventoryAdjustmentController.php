<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryAdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = InventoryAdjustment::with([
            'product',
            'user'
        ])
            ->orderByDesc('adjusted_at')
            ->get();

        return view(
            'inventory-adjustments.index',
            compact('adjustments')
        );
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view(
            'inventory-adjustments.create',
            compact('products')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'product_id' => [
                    'required',
                    'exists:products,id',
                ],

                'actual_quantity' => [
                    'required',
                    'integer',
                    'min:0',
                ],

                'reason' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'notes' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

                'adjusted_at' => [
                    'required',
                    'date',
                ],
            ],
            [
                'product_id.required' =>
                    'Izvēlies preci.',

                'actual_quantity.required' =>
                    'Ievadi faktisko preces daudzumu.',

                'actual_quantity.integer' =>
                    'Daudzumam jābūt veselam skaitlim.',

                'actual_quantity.min' =>
                    'Daudzums nevar būt mazāks par 0.',

                'reason.required' =>
                    'Norādi korekcijas iemeslu.',

                'adjusted_at.required' =>
                    'Norādi inventarizācijas datumu.',
            ]
        );

        DB::transaction(function () use ($validated) {

            $product = Product::lockForUpdate()
                ->findOrFail($validated['product_id']);

            $systemQuantity = $product->quantity;

            $actualQuantity = $validated['actual_quantity'];

            $difference = $actualQuantity - $systemQuantity;

            InventoryAdjustment::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'system_quantity' => $systemQuantity,
                'actual_quantity' => $actualQuantity,
                'difference' => $difference,
                'reason' => $validated['reason'],
                'notes' => $validated['notes'] ?? null,
                'adjusted_at' => $validated['adjusted_at'],
            ]);

            $product->update([
                'quantity' => $actualQuantity,
            ]);
        });

        return redirect()
            ->route('inventory-adjustments.index')
            ->with(
                'success',
                'Inventarizācijas korekcija veiksmīgi reģistrēta.'
            );
    }
}