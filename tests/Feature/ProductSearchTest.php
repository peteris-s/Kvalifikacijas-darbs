
<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('precu meklesana un filtresana darbojas pareizi', function () {

    // Izveido testa lietotāju
    $user = User::factory()->create();

    // Izveido divas kategorijas
    $electronics = Category::create([
        'name' => 'Elektronika',
    ]);

    $clothing = Category::create([
        'name' => 'Apģērbs',
    ]);

    // Prece ar pietiekamu atlikumu
    Product::create([
        'category_id' => $electronics->id,
        'name' => 'iPhone 17',
        'price' => 800,
        'quantity' => 50,
        'minimum_quantity' => 10,
    ]);

    // Prece ar zemu atlikumu
    Product::create([
        'category_id' => $clothing->id,
        'name' => 'Amiri Jeans',
        'price' => 1000,
        'quantity' => 5,
        'minimum_quantity' => 20,
    ]);

    // Meklēšana pēc nosaukuma
    $response = $this->actingAs($user)->get(
        route('products.index', ['search' => 'iPhone'])
    );

    $response->assertOk();
    $response->assertSee('iPhone 17');
    $response->assertDontSee('Amiri Jeans');

    // Filtrēšana pēc kategorijas
    $response = $this->get(
        route('products.index', [
            'category' => $clothing->id,
        ])
    );

    $response->assertOk();
    $response->assertSee('Amiri Jeans');
    $response->assertDontSee('iPhone 17');

    // Filtrēšana pēc zema atlikuma
    $response = $this->get(
        route('products.index', ['stock' => 'low'])
    );

    $response->assertOk();
    $response->assertSee('Amiri Jeans');
    $response->assertDontSee('iPhone 17');
});
