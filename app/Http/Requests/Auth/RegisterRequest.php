<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    /**
     * Может ли пользователь выполнить запрос
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . \App\Models\User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'regex:/^7\d{10}$/'],
        ];
    }

    /**
     * Очищаем номер телефона перед валидацией
     */
    public function prepareForValidation()
    {
        $this->merge([
            'phone' => preg_replace('/\D/', '', $this->phone), // удаляет все нецифровые символы
        ]);
    }

    /**
 * Сообщения об ошибках валидации
 */
public function messages(): array
{
    return [
        'name.required' => 'Поле имя обязательно для заполнения',
        'name.string' => 'Имя должно быть строкой',
        'name.max' => 'Имя не должно превышать 100 символов',

        'email.required' => 'Поле email обязательно для заполнения',
        'email.string' => 'Email должен быть строкой',
        'email.lowercase' => 'Email должен быть в нижнем регистре',
        'email.email' => 'Введите корректный адрес электронной почты',
        'email.max' => 'Email не должен превышать 255 символов',
        'email.unique' => 'Пользователь с таким email уже зарегистрирован',

        'password.required' => 'Поле пароль обязательно для заполнения',
        'password.confirmed' => 'Пароль и его подтверждение не совпадают',

        'phone.required' => 'Поле телефон обязательно для заполнения',
        'phone.string' => 'Телефон должен быть строкой',
        'phone.regex' => 'Телефон должен быть в формате: 7XXXXXXXXXX (11 цифр, начиная с 7)',
    ];
}
}
