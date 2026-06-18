<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // 'sometimes' means: only validate this field if it's present in the request
        return [
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'sku'         => 'sometimes|required|string|unique:products,sku,' . $this->product, // ignore own SKU
            'price'       => 'sometimes|required|numeric|min:0',
            'stock'       => 'sometimes|required|integer|min:0',
            'category'    => 'nullable|string|max:100',
            'is_active'   => 'boolean',
        ];
    }
}