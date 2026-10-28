<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockReceiptDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('precu sanemsana palielina noliktavas atlikumu', function () {

    // Izveido testa lietotāju
    $user = User::factory()->create();

    // Izveido testa kategoriju
    $category = Category::create([
        'name' => 'Testa kategorija',
    ]);

    // Izveido preci ar sākotnējo atlikumu 20
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Testa prece',
        'price' => 10,
        'quantity' => 20,
        'minimum_quantity' => 5,
    ]);

    // Piesakās sistēmā un reģistrē 10 preču saņemšanu
    $response = $this->actingAs($user)->post(
        route('stock-receipts.store'),
        [
            'document_number' => 'TEST-PAV-001',
            'received_at' => now()->format('Y-m-d'),
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 10,
                ],
            ],
        ]
    );

    // Pārbauda veiksmīgu pāradresāciju
    $response->assertRedirect(route('stock-receipts.index'));

    // Pārbauda, vai atlikums palielinājies no 20 uz 30
    expect($product->fresh()->quantity)->toBe(30);

    // Pārbauda, vai pavadzīme saglabāta datubāzē
    $this->assertDatabaseHas('stock_receipt_documents', [
        'document_number' => 'TEST-PAV-001',
    ]);

    // Pārbauda, vai saņemšanas ieraksts saglabāts
    $this->assertDatabaseHas('stock_receipts', [
        'product_id' => $product->id,
        'quantity' => 10,
    ]);
});