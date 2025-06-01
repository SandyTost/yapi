@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 flex items-center justify-center min-h-screen">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-3xl w-full text-center">
            <div>
                <!-- Изображение -->
                <img src="{{ asset('img/thankyou.png') }}" alt="Изображение подтверждения" class="mx-auto mb-4">
                <h2 class="text-5xl font-semibold text-gray-800 mt-4 font-playfair uppercase">Спасибо за покупку!</h2>
                <br>
                <p class="text-gray-700 mt-2">Спасибо за ваш заказ. Мы рады, что вы решили выбрать нас, чтобы
                    порадовать себя настоящим чаем. Вся необходимая информация о заказе отображается в профиле.</p>
                <p class="text-gray-600 mt-8">Номер заказа: <span class="font-semibold">#{{ $order->id }}</span></p>

                <a href="{{ route('profile.index') }}"
                    class="mt-8 inline-block bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200">
                    Перейти в профиль
                </a>
            </div>
        </div>
    </div>

    <script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    // Изначально скрываем меню
    mobileMenu.classList.add('hidden');

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden'); // Скрываем/Показываем меню
        mobileMenu.classList.toggle('is-active'); // Запускаем анимацию
    });
    </script>
@endsection
