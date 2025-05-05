<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Валидация
     */
    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:card,cash',
        ];
    }
}
