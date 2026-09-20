<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockReceipt;
use App\Models\StockReceiptDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockReceiptController extends Controller
{
    public function index()
    {
        $documents = StockReceiptDocument::with([
            'user',
            'receipts.product'
        ])
            ->orderByDesc('received_at')
            ->get();

        return view('stock-receipts.index', compact('documents'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('stock-receipts.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'document_number' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:stock_receipt_documents,document_number',
                ],

                'received_at' => [
                    'required',
                    'date',
                ],

                'products' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'products.*.product_id' => [
                    'required',
                    'exists:products,id',
                    'distinct',
                ],

                'products.*.quantity' => [
                    'required',
                    'integer',
                    'min:1',
                ],
            ],
            [
                'document_number.required' =>
                    'Ievadi pavadzīmes numuru.',

                'document_number.unique' =>
                    'Pavadzīme ar šādu numuru jau eksistē.',

                'received_at.required' =>
                    'Norādi saņemšanas datumu.',

                'products.required' =>
                    'Pavadzīmē jābūt vismaz vienai precei.',

                'products.*.product_id.required' =>
                    'Izvēlies preci.',

                'products.*.product_id.exists' =>
                    'Izvēlētā prece neeksistē.',

                'products.*.product_id.distinct' =>
                    'Vienu un to pašu preci pavadzīmē drīkst pievienot tikai vienu reizi.',

                'products.*.quantity.required' =>
                    'Norādi saņemto daudzumu.',

                'products.*.quantity.integer' =>
                    'Daudzumam jābūt veselam skaitlim.',

                'products.*.quantity.min' =>
                    'Daudzumam jābūt vismaz 1.',
            ]
        );

        DB::transaction(function () use ($validated) {

            $document = StockReceiptDocument::create([
                'document_number' => $validated['document_number'],
                'user_id' => auth()->id(),
                'received_at' => $validated['received_at'],
            ]);

            foreach ($validated['products'] as $item) {

                $product = Product::lockForUpdate()
                    ->findOrFail($item['product_id']);

                StockReceipt::create([
                    'document_id' => $document->id,
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'quantity' => $item['quantity'],
                    'received_at' => $validated['received_at'],
                ]);

                $product->increment(
                    'quantity',
                    $item['quantity']
                );
            }
        });

        return redirect()
            ->route('stock-receipts.index')
            ->with(
                'success',
                'Pavadzīme veiksmīgi reģistrēta un preču atlikumi papildināti.'
            );
    }
}