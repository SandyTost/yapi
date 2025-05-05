<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Правила валидации
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['required', 'string', 'regex:/^7\d{10}$/'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * Очищаем номер телефона перед валидацией
     */
    public function prepareForValidation()
    {
        $phone = $this->phone;

        // Удаляем все нецифровые символы
        $phone = preg_replace('/\D/', '', $phone);

        // Если номер не начинается с 7, то просто игнорируем это поле
        if (strpos($phone, '7') !== 0) {
            $phone = '7' . substr($phone, -10); // Оставляем только последние 10 цифр
        }

        // Преобразуем поле в чистый номер
        $this->merge([
            'phone' => $phone,
        ]);
    }

    /**
     * Сообщения об ошибках
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Поле имя обязательно для заполнения',
            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Имя не должно превышать 255 символов',

            'email.required' => 'Поле email обязательно для заполнения',
            'email.string' => 'Email должен быть строкой',
            'email.lowercase' => 'Email должен быть в нижнем регистре',
            'email.email' => 'Введите корректный email',
            'email.max' => 'Email не должен превышать 255 символов',
            'email.unique' => 'Такой email уже зарегистрирован',

            'phone.required' => 'Поле телефон обязательно для заполнения',
            'phone.string' => 'Телефон должен быть строкой',
            'phone.regex' => 'Телефон должен начинаться с 7 и содержать 11 цифр',

            'street.required' => 'Поле улица обязательно для заполнения',
            'street.string' => 'Улица должна быть строкой',
            'street.max' => 'Улица не должна превышать 255 символов',

            'city.required' => 'Поле город обязательно для заполнения',
            'city.string' => 'Город должен быть строкой',
            'city.max' => 'Город не должен превышать 255 символов',

            'postal_code.required' => 'Поле индекс обязательно для заполнения',
            'postal_code.string' => 'Индекс должен быть строкой',
            'postal_code.max' => 'Индекс не должен превышать 20 символов',
        ];
    }
}
