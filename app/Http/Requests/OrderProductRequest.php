<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer'],
            'order_id' => ['required', 'integer'],
            'product_id' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
