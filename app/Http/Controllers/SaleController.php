<?php

namespace App\Http\Controllers;

use App\DTOs\SaleItemDTO;
use App\Http\Requests\CreateSaleRequest;
use App\Http\Resources\CreateSaleAction;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    public function store(CreateSaleRequest $request): SaleResource|JsonResponse|an
    {
        try {
            $sale = CreateSaleAction::execute(
                SaleItemDTO::createFromMany($request->input('data'))
            );

            return  response()->json(
                [
                    'message' => 'Sale saved successfully',
                    'sale' => new SaleResource($sale)
                ]
            );
        } catch (Exception $exception) {
            Log::error('Error adding sale', ['exception' => $exception]);

            return response()->json(['message' => 'Error adding sale'], 500);
        }
    }

    public function show(int $id): SaleResource|JsonResponse
    {
        $sale = Sale::find($id);

        return $sale ? new SaleResource($sale) : response()->json(['message' => 'Sale not found'], 404);
    }
}
