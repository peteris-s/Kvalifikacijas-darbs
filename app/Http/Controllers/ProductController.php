<?php



namespace App\Http\Controllers;



use App\Models\Product;

use App\Models\Category;

use App\Models\WarehouseLocation;

use App\Models\StockIssue;

use App\Models\CustomerOrderItem;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;

use Throwable;



class ProductController extends Controller

{

    public function index(Request $request)

    {

        $query = Product::with([

            'category',

            'warehouseLocation.parent',

        ]);



        // Meklēšana pēc preces nosaukuma

        if ($request->filled('search')) {

            $query->where(

                'name',

                'like',

                '%' . $request->search . '%'

            );

        }



        // Filtrēšana pēc kategorijas

        if ($request->filled('category')) {

            $query->where(

                'category_id',

                $request->category

            );

        }



        // Filtrēšana pēc atlikuma statusa

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



        // Atļautās kārtošanas iespējas

        $allowedSorts = [

            'name_asc',

            'name_desc',

            'price_asc',

            'price_desc',

            'quantity_asc',

            'quantity_desc',

        ];



        $sort = in_array($request->sort, $allowedSorts, true)

            ? $request->sort

            : 'name_asc';



        // Kārtošana

        switch ($sort) {

            case 'name_desc':

                $query->orderBy('name', 'desc');

                break;



            case 'price_asc':

                $query->orderBy('price', 'asc');

                break;



            case 'price_desc':

                $query->orderBy('price', 'desc');

                break;



            case 'quantity_asc':

                $query->orderBy('quantity', 'asc');

                break;



            case 'quantity_desc':

                $query->orderBy('quantity', 'desc');

                break;



            default:

                $query->orderBy('name', 'asc');

                break;

        }



        $products = $query
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();



        $categories = Category::orderBy('name')->get();



        return view(

            'products.index',

            compact('products', 'categories')

        );

    }



    public function create()

    {

        $categories = Category::orderBy('name')->get();



        $warehouseLocations = WarehouseLocation::where(

            'type',

            'shelf'

        )

            ->with('parent')

            ->orderBy('name')

            ->get();



        return view(

            'products.create',

            compact('categories', 'warehouseLocations')

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



            // Sākotnējais daudzums jaunai precei

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



        $newImage = null;



        try {

            if ($request->hasFile('image')) {

                $newImage = $request

                    ->file('image')

                    ->store('products', 'public');



                $validated['image'] = $newImage;

            }



            Product::create($validated);

        } catch (Throwable $exception) {

            if ($newImage) {

                Storage::disk('public')->delete($newImage);

            }



            throw $exception;

        }



        return redirect()

            ->route('products.index')

            ->with(

                'success',

                'Prece veiksmīgi pievienota.'

            );

    }



    public function edit(Product $product)

    {

        $categories = Category::orderBy('name')->get();



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



    public function update(Request $request, Product $product)

    {

        $validated = $request->validate(

            [

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



                // Esošo atlikumu drīkst iesūtīt,

                // bet to nedrīkst mainīt šajā formā.

                'quantity' => [

                    'sometimes',

                    'integer',

                    Rule::in([(string) $product->quantity]),

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

            ],

            [

                'quantity.in' =>

                    'Preces atlikumu nedrīkst mainīt rediģēšanas formā. Izmanto inventarizācijas sadaļu.',

            ]

        );



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



        // Daudzums nekad netiek mainīts

        // ar parasto preces rediģēšanu.

        unset($validated['quantity']);



        $oldImage = $product->image;

        $newImage = null;



        try {

            if ($request->hasFile('image')) {

                // Vispirms saglabā jauno attēlu.

                $newImage = $request

                    ->file('image')

                    ->store('products', 'public');



                $validated['image'] = $newImage;

            }



            // Saglabā preces datus.

            $product->update($validated);

        } catch (Throwable $exception) {

            // Ja saglabāšana neizdodas,

            // dzēš tikai tikko augšupielādēto attēlu.

            if ($newImage) {

                Storage::disk('public')->delete($newImage);

            }



            throw $exception;

        }



        // Veco attēlu dzēš tikai pēc

        // veiksmīgas preces atjaunināšanas.

        if ($newImage && $oldImage) {

            Storage::disk('public')->delete($oldImage);

        }



        return redirect()

            ->route('products.index')

            ->with(

                'success',

                'Prece veiksmīgi rediģēta.'

            );

    }



    public function destroy(Product $product)

    {

        // Preci nedrīkst dzēst, ja tai ir

        // preču saņemšanas vēsture.

        if ($product->stockReceipts()->exists()) {

            return redirect()

                ->route('products.index')

                ->with(

                    'error',

                    'Preci nevar dzēst, jo tai ir preču saņemšanas vēsture.'

                );

        }



        // Preci nedrīkst dzēst, ja tai ir

        // inventarizācijas korekciju vēsture.

        if ($product->inventoryAdjustments()->exists()) {

            return redirect()

                ->route('products.index')

                ->with(

                    'error',

                    'Preci nevar dzēst, jo tai ir inventarizācijas vēsture.'

                );

        }



        // Preci nedrīkst dzēst, ja tai ir

        // preču izsniegšanas vēsture.

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



        // Preci nedrīkst dzēst, ja tā ir

        // izmantota klienta pasūtījumā.

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



        // Ja precei nav vēstures,

        // dzēš pašu preci.

        $image = $product->image;



        $product->delete();



        // Attēlu dzēš tikai pēc veiksmīgas

        // preces dzēšanas no datubāzes.

        if ($image) {

            Storage::disk('public')->delete($image);

        }



        return redirect()

            ->route('products.index')

            ->with(

                'success',

                'Prece veiksmīgi dzēsta.'

            );

    }

}
