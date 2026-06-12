<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Set to true; later you'll add auth checks here
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku'         => 'required|string|unique:products,sku',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category'    => 'nullable|string|max:100',
            'is_active'   => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'sku.unique' => 'This SKU already exists. Use a different code.',
        ];
    }
}