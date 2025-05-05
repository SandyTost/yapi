<?php

namespace App\Http\Requests\TeaVariety;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeaVarietyRequest extends FormRequest
{
    /**
     * Правила валидация
     *
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:tea_varieties,name|max:50',
        ];
    }

    /**
     * Сообщения об ошибках
     *
     */
    public function messages()
    {
        return [
            'name.required' => 'Поле "Сорт чая" обязательно для заполнения',
            'name.string' => 'Поле "Сорт чая" должно быть строкой',
            'name.unique' => 'Сорт чая с таким именем уже существует',
            'name.max' => 'Имя сорта чая не может превышать 50 символов',
        ];
    }
}
