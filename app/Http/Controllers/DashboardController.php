<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CustomerOrder;
use App\Models\StockReceiptDocument;
use App\Models\InventoryAdjustment;

class DashboardController extends Controller
{
    public function index()
    {
        // Kopējais preču skaits
        $totalProducts = Product::count();

        // Preces ar zemu atlikumu
        $lowStockProducts = Product::whereColumn(
            'quantity',
            '<=',
            'minimum_quantity'
        )->count();

        // Pasūtījumi, kas gaida izsniegšanu
        $pendingOrders = CustomerOrder::where(
            'status',
            'pending'
        )->count();

        // Saņemšanas dokumentu skaits
        $totalReceipts = StockReceiptDocument::count();

        // Inventarizācijas korekciju skaits
        $totalAdjustments = InventoryAdjustment::count();


        // Jaunākās preču saņemšanas
        $latestReceipts = StockReceiptDocument::with([
            'user',
            'receipts.product',
        ])
            ->orderByDesc('received_at')
            ->take(5)
            ->get();


        // Preces, kuras nepieciešams papildināt
        $restockProducts = Product::with('category')
            ->whereColumn(
                'quantity',
                '<=',
                'minimum_quantity'
            )
            ->orderBy('quantity')
            ->take(5)
            ->get();


        return view('dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'pendingOrders',
            'totalReceipts',
            'totalAdjustments',
            'latestReceipts',
            'restockProducts'
        ));
    }
}