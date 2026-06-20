<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'     => ['required', 'integer', 'exists:products,id'],
            'type'           => ['required', 'string', 'in:purchase,sale,adjustment,return'],
            'quantity'       => ['required', 'integer', 'min:1'],
            'remarks'        => ['nullable', 'string', 'max:500'],
        ];
    }
}