<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductOnInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data' => 'required|array',
            'data.*.product_id' => 'required|string|exists:products,id',
            'data.*.quantity' => 'required|numeric|min:1',
        ];
    }
}
