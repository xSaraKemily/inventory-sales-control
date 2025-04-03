<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use WithFaker;

    public function test_inventory_create_and_update(): void
    {
        $productA = Product::factory()->create();
        $productB = Product::factory()->create();

        $quantityA = $this->faker->numberBetween(1, 30);
        $quantityB = $this->faker->numberBetween(1, 30);

        $body =  ['data' => [
            [
                'product_id' => (string) $productA->id,
                'quantity' => $quantityA,
            ],
            [
                'product_id' => (string) $productB->id,
                'quantity' => $quantityB,
            ]
        ]];

        $response = $this->postJson('/api/inventory', $body);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Products added successfully']);

        $this->assertDatabaseHas('inventories', [
            'product_id' => $productA->id,
            'quantity' => $quantityA,
            'last_updated' => null,
        ]);

        $this->assertDatabaseHas('inventories', [
            'product_id' => $productB->id,
            'quantity' => $quantityB,
            'last_updated' => null,
        ]);

        //update test

        $response = $this->postJson('/api/inventory', $body);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Products added successfully']);

        $this->assertDatabaseHas('inventories', [
            'product_id' => $productA->id,
            'quantity' => $quantityA * 2,
        ]);

        $this->assertDatabaseHas('inventories', [
            'product_id' => $productB->id,
            'quantity' => $quantityB * 2,
        ]);

        $this->assertNotNull($productA->inventory->last_updated);
        $this->assertNotNull($productB->inventory->last_updated);
    }

    public function test_fails_when_product_id_is_duplicated(): void
    {
        $product = Product::factory()->create();

        $quantity = $this->faker->numberBetween(1, 30);

        $body =  ['data' => [
            [
                'product_id' => (string) $product->id,
                'quantity' => $quantity,
            ],
            [
                'product_id' => (string) $product->id,
                'quantity' => $quantity,
            ]
        ]];

        $response = $this->postJson('/api/inventory', $body);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => [
            'data.0.product_id',
            'data.1.product_id'
        ]]);
    }

    public function test_fails_when_has_data_is_missing(): void
    {
        $body = ['data' => [
            [
                'product_id' => Product::factory()->create()->id,
            ],
            [
                'quantity' =>  $this->faker->numberBetween(1, 30),
            ],
            [
                'product_id' => Product::factory()->create()->id,
                'quantity' =>  0,
            ],
            [
                'product_id' => $this->faker->uuid(),
                'quantity' =>  $this->faker->numberBetween(1, 30),
            ],
        ]];

        $response = $this->postJson('/api/inventory', $body);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => [
            'data.0.quantity',
            'data.1.product_id',
            'data.2.quantity',
            'data.3.product_id',
        ]]);
    }

    public function test_can_return_data(): void
    {
        $inventoryQuantity = $this->faker->numberBetween(1, 30);

        Inventory::factory()->count($inventoryQuantity)->create();

        $response = $this->getJson('/api/inventory');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'summary' => ['total_projected_profit'],
            'inventory' => ['*' => [
                'id',
                'quantity',
                'total_cost_price',
                'total_sale_price',
                'projected_profit',
                'created_at',
                'updated_at',
                'product' => Schema::getColumnListing('products')
            ]]
        ]);

        $response->assertJsonCount($inventoryQuantity, 'inventory');
    }
}
