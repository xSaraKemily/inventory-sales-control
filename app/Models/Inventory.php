<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Inventory
 *
 * @property int $id
 * @property int $product_id
 * @property int $quantity
 * @property Carbon|null $last_updated
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Product $product
 */
class Inventory extends Model
{
    protected $table = 'inventory';

    protected $casts = [
        'last_updated' => 'datetime',
    ];

    protected $fillable = [
        'product_id',
        'quantity',
        'last_updated',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
