<?php

namespace App\Http\Requests\TeaType;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeaTypeRequest extends FormRequest
{
    /**
     * Правила валидации
     *
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:tea_types,name|max:50',
        ];
    }

    /**
     * Сообщения об ошибках
     *
     */
    public function messages()
    {
        return [
            'name.required' => 'Поле "Тип чая" обязательно для заполнения',
            'name.string' => 'Поле "Тип чая" должно быть строкой',
            'name.unique' => 'Тип чая с таким именем уже существует',
            'name.max' => 'Имя типа чая не может превышать 50 символов',
        ];
    }
}
