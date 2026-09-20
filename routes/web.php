<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockReceiptController;
use App\Http\Controllers\StockIssueController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\InventoryAdjustmentController;
use App\Http\Controllers\PurchasePlanningController;
use App\Http\Controllers\WarehouseLocationController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


// ==============================
// AUTH
// ==============================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==============================
// AUTHENTICATED USERS
// ==============================

Route::middleware('auth')->group(function () {

    // ==============================
    // DASHBOARD
    // ==============================

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // ==============================
    // PRODUCTS - EVERYONE CAN VIEW
    // ==============================

    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');


    // ==============================
    // CUSTOMER ORDERS
    // ==============================

    Route::get('/customer-orders', [CustomerOrderController::class, 'index'])
        ->name('customer-orders.index');

    Route::get('/customer-orders/create', [CustomerOrderController::class, 'create'])
        ->name('customer-orders.create');

    Route::post('/customer-orders', [CustomerOrderController::class, 'store'])
        ->name('customer-orders.store');

    Route::post('/customer-orders/{customerOrder}/issue', [CustomerOrderController::class, 'issue'])
        ->name('customer-orders.issue');


    // ==============================
    // STOCK RECEIPTS
    // ==============================

    Route::get('/stock-receipts', [StockReceiptController::class, 'index'])
        ->name('stock-receipts.index');

    Route::get('/stock-receipts/create', [StockReceiptController::class, 'create'])
        ->name('stock-receipts.create');

    Route::post('/stock-receipts', [StockReceiptController::class, 'store'])
        ->name('stock-receipts.store');


    // ==============================
    // STOCK ISSUES
    // ==============================

    Route::get('/stock-issues', [StockIssueController::class, 'index'])
        ->name('stock-issues.index');

    Route::get('/stock-issues/create', [StockIssueController::class, 'create'])
        ->name('stock-issues.create');

    Route::post('/stock-issues', [StockIssueController::class, 'store'])
        ->name('stock-issues.store');


    // ==============================
    // INVENTORY ADJUSTMENTS
    // ==============================

    Route::get('/inventory-adjustments', [InventoryAdjustmentController::class, 'index'])
        ->name('inventory-adjustments.index');

    Route::get('/inventory-adjustments/create', [InventoryAdjustmentController::class, 'create'])
        ->name('inventory-adjustments.create');

    Route::post('/inventory-adjustments', [InventoryAdjustmentController::class, 'store'])
        ->name('inventory-adjustments.store');


    // ==============================
    // PURCHASE PLANNING
    // ==============================

    Route::get('/purchase-planning', [PurchasePlanningController::class, 'index'])
        ->name('purchase-planning.index');


    // ==============================
    // REPORTS
    // ==============================

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/reports/preview', [ReportController::class, 'preview'])
        ->name('reports.preview');

    Route::get('/reports/excel', [ReportController::class, 'excel'])
        ->name('reports.excel');

    Route::get('/reports/pdf', [ReportController::class, 'pdf'])
        ->name('reports.pdf');


    // ==============================
    // ADMIN ONLY
    // ==============================

    Route::middleware('admin')->group(function () {

        // PRODUCTS
        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');


        // CATEGORIES
        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::get('/categories/create', [CategoryController::class, 'create'])
            ->name('categories.create');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
            ->name('categories.edit');

        Route::put('/categories/{category}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');


        // WAREHOUSE STRUCTURE
        Route::get('/warehouse-locations', [WarehouseLocationController::class, 'index'])
            ->name('warehouse-locations.index');

        Route::get('/warehouse-locations/create', [WarehouseLocationController::class, 'create'])
            ->name('warehouse-locations.create');

        Route::post('/warehouse-locations', [WarehouseLocationController::class, 'store'])
            ->name('warehouse-locations.store');

        Route::get('/warehouse-locations/{warehouseLocation}/edit', [WarehouseLocationController::class, 'edit'])
            ->name('warehouse-locations.edit');

        Route::put('/warehouse-locations/{warehouseLocation}', [WarehouseLocationController::class, 'update'])
            ->name('warehouse-locations.update');

        Route::delete('/warehouse-locations/{warehouseLocation}', [WarehouseLocationController::class, 'destroy'])
            ->name('warehouse-locations.destroy');
    });
});