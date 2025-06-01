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

        <!-- Яндекс Карта -->
        <div class="w-full bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 font-playfair">Мы на карте</h2>
            <div class="rounded-lg overflow-hidden shadow-md">
                <div id="map" style="width: 100%; height: 450px"></div>
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

    <script src="https://api-maps.yandex.ru/2.1/?apikey=ваш_api_ключ&lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        ymaps.ready(init);
        
        function init() {
            var myMap = new ymaps.Map("map", {
                center: [52.283373, 104.281376], // Координаты центра карты
                zoom: 17 // Масштаб карты
            });
            
            var myPlacemark = new ymaps.Placemark([52.283373, 104.281376], {
                hintContent: 'Магазин OnlyGames',
                balloonContent: 'г. Иркутск, ул. Ленина, 1'
            });
            
            myMap.geoObjects.add(myPlacemark);
        }

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