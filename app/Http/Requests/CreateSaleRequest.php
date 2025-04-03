<?php

namespace App\Http\Requests;

use App\Models\Inventory;
use Illuminate\Foundation\Http\FormRequest;

class CreateSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data' => 'required|array',
            'data.*.product_id' => 'required|exists:products,id|distinct',
            'data.*.unit_price' => 'required|numeric|min:0.1',
            'data.*.unit_cost' => 'required|numeric|min:0.1',
            'data.*.quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $productId = request()->input("data.$index.product_id");

                    $inventory = Inventory::where('product_id', $productId)->first();

                    if (!$inventory || $inventory->quantity < $value) {
                        $fail("The product ID $productId doesn't has enough quantity on inventory.");
                    }
                }
            ],
        ];
    }
}
