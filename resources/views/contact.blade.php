@extends('layouts.app')


@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="{{ route('index') }}"
                class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Вернуться на главную
            </a>
            <h1 class="text-3xl font-semibold"> Свяжитесь с нами </h1>
        </div>
    </div>

    <main class="flex-grow container mx-auto px-8 py-4">

        <!-- Правая часть: Google Карта -->
        <div class="w-full bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 font-playfair">Мы на карте</h2>
            <div class="rounded-lg overflow-hidden shadow-md">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d21788.942494837045!2d104.27099974899764!3d52.28778841444497!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5da82925a7a79d0d%3A0x2d40ef87449a3a59!2z0IrRg9GA0LzRi9C60LAg0JrQvtC80LXRgNCw0L3QuNGG0LAg0J7Qv9C40L3RgdGC0Lg!5e0!3m2!1sru!2sru!4v1714737228690!5m2!1sru!2sru"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="mt-4">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 font-playfair">Контактная информация</h2>
                <p class="text-gray-700 leading-relaxed mb-6">
                    Вы можете связаться с нами следующими способами:
                </p>
                <ul class="list-disc list-inside text-gray-700 leading-relaxed">
                    <li class="mb-2">
                        <strong>Телефон:</strong> +7 (999) 999-99-99
                    </li>
                    <li class="mb-2">
                        <strong>Email:</strong> <a href="mailto:OnlyGames228@gmail.com"
                            class="text-green-700 hover:text-green-500 transition-colors duration-200">OnlyGames228@gmail.com</a>
                    </li>
                    <li class="mb-2">
                        <strong>Адрес:</strong> г. Иркутск, ул. Ленина, 1
                    </li>
                </ul>
            </div>
        </div>

    </main>
@endsection
