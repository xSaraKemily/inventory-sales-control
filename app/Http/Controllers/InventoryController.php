<?php

namespace App\Http\Controllers;

use App\Actions\CreateOrUpdateInventoryAction;
use App\Actions\GetInventoryDetailsAction;
use App\DTOs\InventoryDTO;
use App\Http\Requests\AddProductOnInventoryRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function index(): JsonResponse
    {
        return GetInventoryDetailsAction::execute();
    }

    public function store(AddProductOnInventoryRequest $request): JsonResponse
    {
        try {
            CreateOrUpdateInventoryAction::execute(
                InventoryDTO::createFromMany($request->input('data'))
            );

            return response()->json(['message' => 'Products added successfully']);
        } catch (Exception $exception) {
            Log::error('Error adding products', ['exception' => $exception]);

            return response()->json(['message' => 'Error adding products'], 500);
        }
    }
}
