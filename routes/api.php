<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/inventory', InventoryController::class)->only(['index', 'store']);
Route::apiResource('/sales', SaleController::class)->only(['store', 'show']);
