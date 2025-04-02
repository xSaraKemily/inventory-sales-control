<?php

namespace App\Http\Controllers\Controllers;

use App\Actions\AddProductOnInventoryAction;
use App\DTOs\InventoryProductDTO;
use App\Http\Requests\AddProductOnInventoryRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class InventoryController extends Controller
{
    //TODO
    public function store(AddProductOnInventoryRequest $request): JsonResponse
    {
        $message = 'Products added successfully';
        $status = 200;

        try {
            AddProductOnInventoryAction::execute(
                InventoryProductDTO::fromMany($request->get('data'))
            );
        } catch (\Exception $exception) {
            dd($exception); //TODO

            $message = 'Error adding products';
            $status = 500;
        } finally {
            return response()->json(['message' => $message], $status);
        }
    }

    public function index(): Collection
    {
        return ProductResource::collection();
    }
}
