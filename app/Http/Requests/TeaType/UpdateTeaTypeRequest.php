<?php

namespace App\Http\Requests\TeaType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeaTypeRequest extends FormRequest
{
    /**
     * Правила валидации
     *
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tea_types')->ignore($this->teaType),
            ],
        ];
    }


    /**
     * Сообщения об ошибках
     *
     */
    public function messages()
    {
        return [
            'name.required' => 'Поле "Тип чая" обязательно для заполнения.',
            'name.string' => 'Поле "Тип чая" должно быть строкой.',
            'name.unique' => 'Тип чая с таким именем уже существует.',
            'name.max' => 'Имя типа чая не может превышать 50 символов.',
        ];
    }
}
