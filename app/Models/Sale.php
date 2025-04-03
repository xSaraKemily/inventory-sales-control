<?php

namespace App\Models;

use App\Enums\SaleStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Models\Sale
 *
 * @property int $id
 * @property float $total_profit
 * @property float $total_cost
 * @property float $total_amount
 * @property SaleStatusEnum|string $status
 * @property-read SaleItem[]|Collection $items
 */
class Sale extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => SaleStatusEnum::class,
    ];

    protected $fillable = [
        'total_profit',
        'total_cost',
        'total_amount',
        'status'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
