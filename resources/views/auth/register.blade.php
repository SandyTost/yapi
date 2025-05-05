@extends('layouts.guest')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 font-playfair text-center">Регистрация</h2>
    <form action="{{ route('register') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Имя:</label>
            <input type="text" id="name" name="name" maxlength="50"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Введите имя">
        </div>
        <div>
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" id="email" name="email"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Введите email">
        </div>
        <div>
            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Телефон:</label>
            <input type="text" id="phone" name="phone"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Введите телефон">
        </div>
        <div>
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Пароль:</label>
            <input type="password" id="password" name="password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Введите пароль">
        </div>
        <div>
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Подтвердите
                пароль:</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Подтвердите пароль">
        </div>
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            <button type="submit"
                class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full">
                Зарегистрироваться
            </button>
        </div>

        <div>
            <a href="{{ route('login') }}"
                class="bg-green-700 hover:bg-green-800 text-center text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full block">
                Войти
            </a>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/inputmask/dist/inputmask.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var phoneInput = document.getElementById('phone');
            var im = new Inputmask("+7 (999) 999-99-99", {
                clearMaskOnLostFocus: true,
                onBeforePaste: function(pastedValue, opts) {
                    return pastedValue.replace(/\D/g, '');
                }
            });
            im.mask(phoneInput);
        });
    </script>
@endsection
