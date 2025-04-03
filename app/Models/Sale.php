<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'total_profit',
        'total_cost',
        'total_amount',
        'status',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
