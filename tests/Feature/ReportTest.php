
<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('atskaisu generesana darbojas pareizi', function () {

    // Izveidojam lietotāju
    $user = User::factory()->create();

    $this->actingAs($user);

    // Izveidojam kategoriju
    $category = Category::create([
        'name' => 'Testa kategorija',
    ]);

    // Izveidojam preci
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Testa atskaites prece',
        'price' => 25,
        'quantity' => 30,
        'minimum_quantity' => 5,
    ]);

    // 1. Pārbaudām atskaites priekšskatījumu
    $response = $this->get(
        route('reports.preview', [
            'report_type' => 'stock',
        ])
    );

    $response->assertOk();

    // Pārbaudām, vai atskaitē ir prece
    $response->assertSee('Testa atskaites prece');

    // Pārbaudām, vai atskaitē ir pareizie dati
    $response->assertViewHas('reportType', 'stock');

    $response->assertViewHas('data', function ($data) use ($product) {
        return $data->contains('id', $product->id);
    });

    // 2. Pārbaudām PDF eksportu
    $pdfResponse = $this->get(
        route('reports.pdf', [
            'report_type' => 'stock',
        ])
    );

    $pdfResponse->assertOk();

    $this->assertStringContainsString(
        'application/pdf',
        $pdfResponse->headers->get('Content-Type', '')
    );

    // 3. Pārbaudām Excel eksportu
    $excelResponse = $this->get(
        route('reports.excel', [
            'report_type' => 'stock',
        ])
    );

    $excelResponse->assertOk();

    $this->assertStringContainsString(
        'spreadsheetml',
        $excelResponse->headers->get('Content-Type', '')
    );
});
