<?php

namespace App\Http\Requests\TeaVariety;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeaVarietyRequest extends FormRequest
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
                Rule::unique('tea_varieties')->ignore($this->teaType),
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
            'name.required' => 'Поле "Сорт чая" обязательно для заполнения.',
            'name.string' => 'Поле "Сорт чая" должно быть строкой.',
            'name.unique' => 'Сорт чая с таким именем уже существует.',
            'name.max' => 'Имя сорта чая не может превышать 50 символов.',
        ];
    }
}
