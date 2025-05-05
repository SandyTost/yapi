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
            <h1 class="text-3xl font-semibold"> Новости </h1>
        </div>
    </div>
    <main class="flex-grow container mx-auto px-8 py-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

            <!-- Новость 1 -->
            <div
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                <!-- Изображение -->
                <img src="{{ asset('img/char.jpg') }}" alt="Новый сорт чая: &quot;Золотой Дракон&quot;"
                    class="w-full h-56 object-cover">
                <!-- Контент -->
                <div class="p-4 sm:p-6 flex flex-col flex-grow">
                    <!-- Заголовок -->
                    <h2
                        class="text-xl font-semibold text-gray-800 mb-2 hover:text-green-600 transition-colors duration-200 font-playfair">
                        Новый сорт чая: "Золотой Дракон"
                    </h2>
                    <!-- Описание -->
                    <p class="text-gray-700 leading-relaxed mb-3 flex-grow text-justify">
                        Представляем вам наш новый эксклюзивный сорт чая "Золотой Дракон",
                        собранный вручную в горах Юньнань. Он обладает неповторимым ароматом и изысканным вкусом.
                        Этот чай - настоящее сокровище, которое мы рады предложить нашим клиентам.
                    </p>
                </div>

                <!-- Ссылка "Читать далее" -->
                <a href="newscont.html"
                    class="text-green-800 hover:text-green-600 font-medium transition-colors duration-200 sm:p-6 pt-0 block">Читать
                    далее</a>
            </div>

            <!-- Новость 2 -->
            <div
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                <!-- Изображение -->
                <img src="{{ asset('img/char.jpg') }}" alt="Новая акция: Чайная церемония в подарок!"
                    class="w-full h-56 object-cover">
                <!-- Контент -->
                <div class="p-4 sm:p-6 flex flex-col flex-grow">
                    <!-- Заголовок -->
                    <h2
                        class="text-xl font-semibold text-gray-800 mb-2 hover:text-green-600 transition-colors duration-200 font-playfair">
                        Новая акция: Чайная церемония в подарок!
                    </h2>
                    <!-- Описание -->
                    <p class="text-gray-700 leading-relaxed mb-3 flex-grow text-justify">
                        Примите участие в нашей новой акции и получите возможность выиграть чайную церемонию для двоих!
                        Просто совершите покупку на сумму от 1500 рублей, и вы автоматически становитесь участником
                        розыгрыша.
                    </p>
                </div>

                <!-- Ссылка "Читать далее" -->
                <a href="newscont2.html"
                    class="text-green-800 hover:text-green-600 font-medium transition-colors duration-200 sm:p-6 pt-0 block">Читать
                    далее</a>
            </div>

            <!-- Новость 3 -->
            <div
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                <!-- Изображение -->
                <img src="{{ asset('img/char.jpg') }}" alt="Скидки на чайные наборы в честь Дня чая!"
                    class="w-full h-56 object-cover">
                <!-- Контент -->
                <div class="p-4 sm:p-6 flex flex-col flex-grow">
                    <!-- Заголовок -->
                    <h2
                        class="text-xl font-semibold text-gray-800 mb-2 hover:text-green-600 transition-colors duration-200 font-playfair">
                        Скидки на чайные наборы в честь Дня чая!
                    </h2>
                    <!-- Описание -->
                    <p class="text-gray-700 leading-relaxed mb-3 flex-grow text-justify">
                        В честь Международного дня чая мы дарим скидки до 30% на все чайные наборы!
                        Не упустите возможность приобрести идеальный подарок для себя и своих близких.
                    </p>
                </div>

                <!-- Ссылка "Читать далее" -->
                <a href="newscont3.html"
                    class="text-green-800 hover:text-green-600 font-medium transition-colors duration-200 sm:p-6 pt-0 block">Читать
                    далее</a>
            </div>
    </main>
@endsection
