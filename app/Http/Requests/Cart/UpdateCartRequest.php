<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    /**
     * Правила валидации
     */
    public function rules(): array
    {
        return [
            'quantity' => ['nullable', 'integer', 'min:1'],
            'action' => ['nullable', 'in:increment,decrement'],
        ];
    }
}
