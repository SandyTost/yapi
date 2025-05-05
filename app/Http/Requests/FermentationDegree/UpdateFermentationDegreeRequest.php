<?php

namespace App\Http\Requests\FermentationDegree;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFermentationDegreeRequest extends FormRequest
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
                Rule::unique('fermentation_degrees')->ignore($this->teaType),
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
            'name.required' => 'Поле "Степень ферментации" обязательно для заполнения.',
            'name.string' => 'Поле "Степень ферментации" должно быть строкой.',
            'name.unique' => 'Степень ферментации с таким именем уже существует.',
            'name.max' => 'Имя Степень ферментации не может превышать 50 символов.',
        ];
    }
}
