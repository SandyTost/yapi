@extends('layouts.guest')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 font-playfair text-center">Вход</h2>
    <form action="{{ route('login') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" id="email" name="email"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Введите email">
        </div>
        <div>
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Пароль:</label>
            <input type="password" id="password" name="password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Введите пароль">
        </div>

        <div>
            <button type="submit"
                class="bg-green-700 hover:bg-green-800 text-center text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full block">
                Войти
            </button>
        </div>
        <!-- Добавили "Запомнить пароль" -->
        {{-- <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" type="checkbox" name="remember"
                    class="h-4 w-4 text-green-600 focus:ring-green-500 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-900">Запомнить меня</label>
            </div>
            <a href="#" class="text-sm text-green-600 hover:text-green-800">Забыли пароль?</a>
        </div> --}}
        <!-- Войти через -->
        <div>
            <p class="text-gray-700">Войти через:</p>
            <div class="flex mt-2">
                <a href="#"
                    class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white shadow-md hover:shadow-lg transition-shadow duration-200">
                    <img src="{{ asset('img/Yandex Logo.png') }}" alt="Яндекс" class="h-6">
                </a>
            </div>
        </div>


    </form>
    <!-- Заменить на кнопку -->
    <div class="flex mt-6">
        <a href="{{ route('register') }}"
            class="bg-green-700 hover:bg-green-800 text-center text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full block">
            Зарегистрироваться
        </a>
    </div>
@endsection
