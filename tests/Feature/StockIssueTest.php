
<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('precu izsniegsana samazina noliktavas atlikumu', function () {

    // Izveido testa lietotāju
    $user = User::factory()->create();

    // Izveido kategoriju
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

    // Reģistrē 5 preču izsniegšanu
    $response = $this->actingAs($user)->post(
        route('stock-issues.store'),
        [
            'order_number' => 'TEST-ORD-001',
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 5,
                ],
            ],
            'notes' => 'Automātiskais tests',
        ]
    );

    // Pārbauda veiksmīgu pāradresāciju
    $response->assertRedirect(route('stock-issues.index'));

    // Pārbauda, vai atlikums samazinājies no 20 uz 15
    expect($product->fresh()->quantity)->toBe(15);

    // Pārbauda, vai izsniegšana saglabāta datubāzē
    $this->assertDatabaseHas('stock_issues', [
        'order_number' => 'TEST-ORD-001',
        'product_id' => $product->id,
        'quantity' => 5,
        'user_id' => $user->id,
    ]);
});
