<?php

use App\Http\Controllers\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::post('/inventory', [InventoryController::class, 'store']);
