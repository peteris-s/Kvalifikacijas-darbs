<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\WarehouseLocation;
use App\Models\StockIssue;
use App\Models\CustomerOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with([
            'category',
            'warehouseLocation.parent',
        ]);

        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        if ($request->filled('stock')) {
            if ($request->stock === 'low') {
                $query->whereColumn(
                    'quantity',
                    '<=',
                    'minimum_quantity'
                );
            }

            if ($request->stock === 'available') {
                $query->whereColumn(
                    'quantity',
                    '>',
                    'minimum_quantity'
                );
            }
        }

        $products = $query
            ->orderBy('name')
            ->get();

        $categories = Category::orderBy('name')
            ->get();

        return view(
            'products.index',
            compact('products', 'categories')
        );
    }


    public function create()
    {
        $categories = Category::orderBy('name')
            ->get();

        $warehouseLocations = WarehouseLocation::where(
            'type',
            'shelf'
        )
            ->with('parent')
            ->orderBy('name')
            ->get();

        return view(
            'products.create',
            compact(
                'categories',
                'warehouseLocations'
            )
        );
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'warehouse_location_id' => [
                'nullable',
                'exists:warehouse_locations,id',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],
            'minimum_quantity' => [
                'required',
                'integer',
                'min:0',
            ],
            'image' => [
                'nullable',
                'image',
                'max:10240',
            ],
        ]);


        if (!empty($validated['warehouse_location_id'])) {
            $location = WarehouseLocation::findOrFail(
                $validated['warehouse_location_id']
            );

            if ($location->type !== 'shelf') {
                return back()
                    ->withErrors([
                        'warehouse_location_id' =>
                            'Preci drīkst novietot tikai plauktā.',
                    ])
                    ->withInput();
            }
        }


        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }


        Product::create($validated);


        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Prece veiksmīgi pievienota.'
            );
    }


    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')
            ->get();

        $warehouseLocations = WarehouseLocation::where(
            'type',
            'shelf'
        )
            ->with('parent')
            ->orderBy('name')
            ->get();

        return view(
            'products.edit',
            compact(
                'product',
                'categories',
                'warehouseLocations'
            )
        );
    }


    public function update(
        Request $request,
        Product $product
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'warehouse_location_id' => [
                'nullable',
                'exists:warehouse_locations,id',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],
            'minimum_quantity' => [
                'required',
                'integer',
                'min:0',
            ],
            'image' => [
                'nullable',
                'image',
                'max:10240',
            ],
        ]);


        if (!empty($validated['warehouse_location_id'])) {
            $location = WarehouseLocation::findOrFail(
                $validated['warehouse_location_id']
            );

            if ($location->type !== 'shelf') {
                return back()
                    ->withErrors([
                        'warehouse_location_id' =>
                            'Preci drīkst novietot tikai plauktā.',
                    ])
                    ->withInput();
            }
        }


        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')
                    ->delete($product->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }


        $product->update($validated);


        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Prece veiksmīgi rediģēta.'
            );
    }


    public function destroy(Product $product)
    {
        /*
         * Preci nedrīkst dzēst, ja tai ir
         * preču saņemšanas vēsture.
         */
        if ($product->stockReceipts()->exists()) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Preci nevar dzēst, jo tai ir preču saņemšanas vēsture.'
                );
        }


        /*
         * Preci nedrīkst dzēst, ja tai ir
         * inventarizācijas korekciju vēsture.
         */
        if ($product->inventoryAdjustments()->exists()) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Preci nevar dzēst, jo tai ir inventarizācijas vēsture.'
                );
        }


        /*
         * Preci nedrīkst dzēst, ja tai ir
         * preču izsniegšanas vēsture.
         */
        if (
            StockIssue::where(
                'product_id',
                $product->id
            )->exists()
        ) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Preci nevar dzēst, jo tai ir preču izsniegšanas vēsture.'
                );
        }


        /*
         * Preci nedrīkst dzēst, ja tā ir
         * izmantota klienta pasūtījumā.
         */
        if (
            CustomerOrderItem::where(
                'product_id',
                $product->id
            )->exists()
        ) {
            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Preci nevar dzēst, jo tā ir izmantota klienta pasūtījumā.'
                );
        }


        /*
         * Ja precei nav nekādas vēstures,
         * izdzēšam attēlu un pašu preci.
         */
        if ($product->image) {
            Storage::disk('public')
                ->delete($product->image);
        }


        $product->delete();


        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Prece veiksmīgi dzēsta.'
            );
    }
}