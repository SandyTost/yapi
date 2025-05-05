<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Правила валидации
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'max:2048'],
            'price' => ['required', 'integer', 'min:0'],
            'tea_type_id' => ['required', 'exists:tea_types,id'],
            'origin_region_id' => ['required', 'exists:origin_regions,id'],
            'tea_variety_id' => ['required', 'exists:tea_varieties,id'],
            'fermentation_degree_id' => ['required', 'exists:fermentation_degrees,id'],
            'storage' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название товара обязательно для заполнения',
            'name.max' => 'Название не должно превышать 100 символов',
            'description.required' => 'Описание обязательно для заполнения',
            'image.required' => 'Изображение обязательно для загрузки',
            'image.image' => 'Файл должен быть изображением',
            'image.max' => 'Изображение не должно превышать 2MB',
            'price.required' => 'Цена обязательна для заполнения',
            'price.integer' => 'Цена должна быть целым числом',
            'price.min' => 'Цена не может быть отрицательной',
            'tea_type_id.required' => 'Выберите тип чая',
            'tea_type_id.exists' => 'Выбранный тип чая не существует',
            'origin_region_id.required' => 'Выберите регион происхождения',
            'origin_region_id.exists' => 'Выбранный регион не существует',
            'tea_variety_id.required' => 'Выберите сорт чая',
            'tea_variety_id.exists' => 'Выбранный сорт не существует',
            'fermentation_degree_id.required' => 'Выберите степень ферментации',
            'fermentation_degree_id.exists' => 'Выбранная степень не существует',
            'storage.required' => 'Укажите условие хранения',
        ];
    }

}
