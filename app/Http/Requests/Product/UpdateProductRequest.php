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
            'price' => 'required|numeric|min:0.01',
            'weight_grams' => 'required|integer|min:1',
            'stock_quantity' => 'required|integer|min:0',
            'tea_type_id' => 'required|exists:tea_types,id',
            'origin_region_id' => 'required|exists:origin_regions,id',
            'tea_variety_id' => 'required|exists:tea_varieties,id',
            'fermentation_degree_id' => 'required|exists:fermentation_degrees,id',
        ];
    }

    /**
     * Сообщения об ошибках.
     *
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Название товара обязательно для заполнения',
            'name.max' => 'Название товара не может превышать 100 символов',

            'description.required' => 'Описание товара обязательно для заполнения',
            'description.max' => 'Описание товара не может превышать 1000 символов',

            'storage.required' => 'Условия хранения обязательны для заполнения',
            'storage.max' => 'Условия хранения не могут превышать 500 символов',

            'image.image' => 'Вы должны загрузить изображение',
            'image.mimes' => 'Изображение должно быть формата jpeg, png, jpg или gif',
            'image.max' => 'Изображение не должно превышать 2MB',

            'price.required' => 'Цена товара обязательна',
            'price.numeric' => 'Цена должна быть числом',
            'price.min' => 'Цена должна быть больше нуля',

            'weight_grams.required' => 'Вес товара обязателен',
            'weight_grams.integer' => 'Вес должен быть целым числом',
            'weight_grams.min' => 'Вес должен быть больше нуля',

            'stock_quantity.required' => 'Количество на складе обязательно',
            'stock_quantity.integer' => 'Количество должно быть целым числом',
            'stock_quantity.min' => 'Количество не может быть отрицательным',

            'tea_type_id.required' => 'Тип чая обязателен для выбора',
            'tea_type_id.exists' => 'Выбранный тип чая не существует',

            'origin_region_id.required' => 'Регион происхождения обязателен для выбора',
            'origin_region_id.exists' => 'Выбранный регион происхождения не существует',

            'tea_variety_id.required' => 'Сорт чая обязателен для выбора',
            'tea_variety_id.exists' => 'Выбранный сорт чая не существует',

            'fermentation_degree_id.required' => 'Степень ферментации обязательна для выбора',
            'fermentation_degree_id.exists' => 'Выбранная степень ферментации не существует',
        ];
    }
}