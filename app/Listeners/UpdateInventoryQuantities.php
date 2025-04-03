<?php

namespace App\Listeners;

use App\Events\SaleCompleted;
use App\Models\SaleItem;

class UpdateInventoryQuantities
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SaleCompleted $event): void
    {
        $event->sale->items()
            ->whereHas('product.inventory')
            ->each(function (SaleItem $saleItem) {
                $inventoryQuantity = $saleItem->product->inventory->quantity;

                if ($inventoryQuantity > $saleItem->quantity) {
                    $saleItem->product->inventory->update(['quantity' => $inventoryQuantity - $saleItem->quantity]);

                    return;
                }

                $saleItem->product->inventory->delete();
            });
    }
}
