<?php

namespace Feature;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use WithFaker;

    public function test_can_save_sales_and_update_inventory_after(): void
    {
        $body = null;

        $inventoryCount = $this->faker->numberBetween(1, 10);

        $inventories = Inventory::factory()->count($inventoryCount)->create();

        $inventories->each(function (Inventory $inventory) use (&$body) {
            $body['items'][] = [
                'product_id' => $inventory->product_id,
                'unit_price' => $this->faker->randomFloat(2, 1, 9999),
                'unit_cost' => $this->faker->randomFloat(2, 1, 9999),
                'quantity' => $this->faker->numberBetween(1, $inventory->quantity)
            ];
        });

        $response = $this->postJson('/api/sales', $body);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Sale saved successfully']);
        $response->assertJsonStructure([
            'message',
            'sale' => [
                ...Schema::getColumnListing('sales'),
                'items' => [
                    '*' => Schema::getColumnListing('sale_items'),
                ]
            ]
        ]);

        $this->assertDatabaseCount('sales', 1);
        $this->assertDatabaseCount('sale_items', $inventoryCount);

        //update inventory test

        $saleItemsCollection = Collection::make($body['items']);

        $inventoryDeletionsCount = 0;

        $inventories->each(function (Inventory $inventory) use ($saleItemsCollection, &$inventoryDeletionsCount) {
            $oldInventoryQuantity = $inventory->quantity;

            $saleItemQuantity = $saleItemsCollection->where('product_id', $inventory->product_id)->first()['quantity'];

            if ($oldInventoryQuantity > $saleItemQuantity) {
                $this->assertEquals($inventory->refresh()->quantity, $oldInventoryQuantity - $saleItemQuantity);

                return;
            }

            $inventoryDeletionsCount++;
        });

        $this->assertDatabaseCount('inventories', $inventoryCount - $inventoryDeletionsCount);
    }

    public function test_can_return_sale(): void
    {
        $sales = Sale::factory()
            ->has(SaleItem::factory()->count($this->faker->numberBetween(1, 10)), 'items')
            ->create();

        $response = $this->getJson('/api/sales/' . $sales->id);

        $response->assertJsonStructure([
            'data' => [
                ...Schema::getColumnListing('sales'),
                'items' => [
                    '*' => Schema::getColumnListing('sale_items'),
                ]
            ]
        ]);
    }

    public function test_error_when_item_quantity_is_greater_than_inventory(): void
    {
        $inventory = Inventory::factory()->create();

        $body['items'][] = [
            'product_id' => $inventory->product_id,
            'unit_price' => $this->faker->randomFloat(2, 1, 9999),
            'unit_cost' => $this->faker->randomFloat(2, 1, 9999),
            'quantity' => $this->faker->numberBetween($inventory->quantity + 1)
        ];

        $response = $this->postJson('/api/sales', $body);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message']);
    }
}
