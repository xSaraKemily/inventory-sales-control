<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * App\Models\SaleItem
 *
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property int $quantity
 * @property float $unit_price
 * @property float $unit_cost
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Sale $sale
 * @property-read Product $product
 */
class SaleItem extends Model
{
    protected $fillable = [
      'sale_id',
      'product_id',
      'quantity',
      'unit_price',
      'unit_cost',
      'created_at',
      'updated_at',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
