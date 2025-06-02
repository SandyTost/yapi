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
            'payment_method' => ['required', 'in:card,cash'],
            'delivery_address_id' => ['required', 'exists:delivery_addresses,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'Выберите способ оплаты',
            'payment_method.in' => 'Недопустимый способ оплаты',
            'delivery_address_id.required' => 'Выберите адрес доставки',
            'delivery_address_id.exists' => 'Выбранный адрес не существует',
        ];
    }
}