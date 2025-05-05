<?php

namespace App\Http\Requests\FermentationDegree;

use Illuminate\Foundation\Http\FormRequest;

class StoreFermentationDegreeRequest extends FormRequest
{
    /**
     * Правила валидация
     *
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:fermentation_degrees,name|max:50',
        ];
    }

    /**
     * Сообщения об ошибках
     *
     */
    public function messages()
    {
        return [
            'name.required' => 'Поле "Степень ферментации" обязательно для заполнения',
            'name.string' => 'Поле "Степень ферментации" должно быть строкой',
            'name.unique' => 'Степень ферментации с таким именем уже существует',
            'name.max' => 'Имя степень ферментации не может превышать 50 символов',
        ];
    }
}
