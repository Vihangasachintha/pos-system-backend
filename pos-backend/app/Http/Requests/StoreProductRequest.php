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
            'category_id'     => 'required|exists:categories,id',
            'brand_id'        => 'nullable|exists:brands,id',
            'name'            => 'required|string|max:255',
            'barcode'         => 'nullable|string|unique:products,barcode',
            'sku'             => 'required|string|unique:products,sku',
            'purchase_price'  => 'required|numeric|min:0',
            'selling_price'   => 'required|numeric|min:0',
            'is_active'       => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'sku.unique' => 'This SKU already exists. Use a different code.',
        ];
    }
}
