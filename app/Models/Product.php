<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $name
 * @property int $sku
 * @property int $description
 * @property float $cost_price
 * @property float $sale_price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Inventory|null $inventory
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'description',
        'cost_price',
        'sale_price',
    ];

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }
}
