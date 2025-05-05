<?php

namespace App\Http\Requests\OriginRegion;

use Illuminate\Foundation\Http\FormRequest;

class StoreOriginRegionRequest extends FormRequest
{
    /**
     * Правила валидации
     *
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:origin_regions,name|max:50',
        ];
    }

    /**
     * Сообщения об ошибках
     *
     */
    public function messages()
    {
        return [
            'name.required' => 'Поле обязательно для заполнения',
            'name.string' => 'Поле должно быть строкой',
            'name.unique' => 'Регион происхождения с таким именем уже существует',
            'name.max' => 'Регион происхождения не может превышать 50 символов',
        ];
    }
}
