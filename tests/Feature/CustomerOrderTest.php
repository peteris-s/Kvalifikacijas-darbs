
<?php

use App\Models\Category;
use App\Models\CustomerOrder;
use App\Models\Product;
use App\Models\StockIssue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('pasutijuma izpilde samazina noliktavas atlikumu', function () {

    // Izveidojam lietotāju
    $user = User::factory()->create();

    $this->actingAs($user);

    // Izveidojam kategoriju
    $category = Category::create([
        'name' => 'Testa kategorija',
    ]);

    // Izveidojam preci ar 20 gabaliem
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Testa prece',
        'price' => 10,
        'quantity' => 20,
        'minimum_quantity' => 5,
    ]);

    // Izveidojam pasūtījumu
    $order = CustomerOrder::create([
        'order_number' => 'TEST-ORDER-001',
        'status' => 'pending',
        'ordered_at' => now(),
    ]);

    // Pasūtījumā pievienojam 5 preces
    $order->items()->create([
        'product_id' => $product->id,
        'quantity' => 5,
    ]);

    // Pirms izsniegšanas atlikumam jābūt 20
    expect($product->fresh()->quantity)->toBe(20);

    // Izsniedzam pasūtījumu
    $response = $this->post(
        route('customer-orders.issue', $order)
    );

    // Pārbaudām pāradresāciju
    $response->assertRedirect(
        route('customer-orders.index')
    );

    // Pārbaudām, ka atlikums samazinājies
    expect($product->fresh()->quantity)->toBe(15);

    // Pārbaudām pasūtījuma statusu
    expect($order->fresh()->status)->toBe('issued');

    // Pārbaudām izsniegšanas ierakstu datubāzē
    $this->assertDatabaseHas('stock_issues', [
        'order_number' => 'TEST-ORDER-001',
        'product_id' => $product->id,
        'quantity' => 5,
    ]);

    // Pārbaudām, ka izveidots viens izsniegšanas ieraksts
    expect(
        StockIssue::where('order_number', 'TEST-ORDER-001')->count()
    )->toBe(1);
});
