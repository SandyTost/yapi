@extends('layouts.guest')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 font-playfair text-center">Вход</h2>
    <form action="{{ route('login') }}" method="POST" class="space-y-6">
        @csrf
        
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{
                            str_replace([
                                'The email field is required.',
                                'The password field is required.',
                                'The email must be a valid email address.',
                                'The password must be at least 8 characters.',
                                'These credentials do not match our records.'
                            ], [
                                'Поле Email обязательно для заполнения.',
                                'Поле Пароль обязательно для заполнения.',
                                'Введите корректный email адрес.',
                                'Пароль должен содержать минимум 8 символов.',
                                'Неверный email или пароль.'
                            ], $error)
                        }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Остальная часть формы остается без изменений -->
        <div>
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                placeholder="Введите email">
            @error('email')
                <p class="mt-1 text-sm text-red-600">
                    @if($message == 'The email field is required.')
                        Поле Email обязательно для заполнения.
                    @elseif($message == 'The email must be a valid email address.')
                        Введите корректный email адрес.
                    @else
                        {{ $message }}
                    @endif
                </p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Пароль:</label>
            <input type="password" id="password" name="password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                placeholder="Введите пароль">
            @error('password')
                <p class="mt-1 text-sm text-red-600">
                    @if($message == 'The password field is required.')
                        Поле Пароль обязательно для заполнения.
                    @elseif($message == 'The password must be at least 8 characters.')
                        Пароль должен содержать минимум 8 символов.
                    @else
                        {{ $message }}
                    @endif
                </p>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full">
                Войти
            </button>
        </div>

        <div>
            <p class="text-gray-700">Войти через:</p>
            <div class="flex mt-2">
                <a href="{{ route('yandex') }}"
                    class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white shadow-md hover:shadow-lg transition-shadow duration-200">
                    <img src="{{ asset('img/Yandex Logo.png') }}" alt="Яндекс" class="h-6">
                </a>
            </div>
        </div>
    </form>

    <div class="mt-6">
        <a href="{{ route('register') }}"
            class="bg-green-700 hover:bg-green-800 text-center text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full block">
            Зарегистрироваться
        </a>
    </div>
@endsection