<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Правила валидации
     *
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:1',
            'tea_type' => 'required|exists:tea_types,id',
            'origin' => 'required|exists:origin_regions,id',
            'sort' => 'required|string|max:100',
            'fermentation' => 'required|exists:fermentation_degrees,id',
            'storage' => 'required|string|max:500',
        ];
    }

    /**
     * Сообщения об ошибках.
     *
     */
    public function messages()
    {
        return [
            'name.required' => 'Название товара обязательно для заполнения',
            'name.max' => 'Название товара не может превышать 100 символов',
            'description.required' => 'Описание товара обязательно для заполнения',
            'description.max' => 'Описание товара не может превышать 1000 символов',
            'image.image' => 'Вы должны загрузить изображение.',
            'image.mimes' => 'Изображение должно быть формата jpeg, png, jpg или gif',
            'image.max' => 'Изображение не должно превышать 2MB',
            'price.required' => 'Цена товара обязательна',
            'price.numeric' => 'Цена должна быть числом',
            'price.min' => 'Цена должна быть больше нуля',
            'tea_type.required' => 'Тип чая обязателен для выбора',
            'tea_type.exists' => 'Выбранный тип чая не существует',
            'origin.required' => 'Регион происхождения обязателен для выбора',
            'origin.exists' => 'Выбранный регион происхождения не существует',
            'sort.required' => 'Сорт чая обязателен для заполнения',
            'sort.max' => 'Сорт чая не может превышать 100 символов',
            'fermentation.required' => 'Степень ферментации обязательна для выбора',
            'fermentation.exists' => 'Выбранная степень ферментации не существует',
            'storage.required' => 'Условия хранения обязательны для заполнения',
            'storage.max' => 'Условия хранения не могут превышать 500 символов',
        ];
    }
}
