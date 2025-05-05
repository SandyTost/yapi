<?php

namespace App\Http\Requests\OriginRegion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOriginRegionRequest extends FormRequest
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
                Rule::unique('origin_regions')->ignore($this->teaType),
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
            'name.required' => 'Поле обязательно для заполнения.',
            'name.string' => 'Поле должно быть строкой.',
            'name.unique' => 'Регион происхождения с таким именем уже существует.',
            'name.max' => 'Регион происхождения не может превышать 50 символов.',
        ];
    }
}
