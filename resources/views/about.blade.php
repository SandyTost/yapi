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
            <h1 class="text-3xl font-semibold"> О нас </h1>
        </div>
    </div>
    <main class="flex-grow container mx-auto px-8 py-4">
        <!-- Раздел "Наша история" -->
        <section class="mb-12">
            <h3 class="text-3xl font-semibold text-gray-800 mb-6 border-b-2 border-black pb-2 font-playfair">Наша история
            </h3>
            <p class="text-lg text-gray-700 leading-relaxed text-justify">
                Всё началось с маленькой мечты: подарить людям возможность наслаждаться настоящим, качественным чаем.
                Компания Tea Break была основана в 2024 году в прекрасном городе Иркутске, где мы, окруженные красотой
                природы,
                вдохновились на создание чего-то особенного. С тех пор мы усердно работаем, чтобы найти лучшие сорта чая со
                всего мира и предложить их вам.
            </p>
        </section>

        <!-- Раздел "Наша миссия" -->
        <section class="mb-12">
            <h3 class="text-3xl font-semibold text-gray-800 mb-6 border-b-2 border-black pb-2 font-playfair">Наша миссия
            </h3>
            <p class="text-lg text-gray-700 leading-relaxed text-justify">
                Мы верим, что чай — это не просто напиток, это возможность для отдыха, общения и наслаждения моментом.
                Наша миссия — сделать чайную культуру доступной каждому, предлагая широкий выбор сортов чая на любой вкус
                и помогая людям открывать для себя новые чайные горизонты. Мы стремимся к тому, чтобы каждый глоток чая Tea
                Break
                приносил вам радость и умиротворение.
            </p>
        </section>

        <!-- Раздел "Наша команда" -->
        <section class="mb-12">
            <h3 class="text-3xl font-semibold text-gray-800 mb-6 border-b-2 border-black pb-2 font-playfair">Наша команда
            </h3>
            <p class="text-lg text-gray-700 leading-relaxed text-justify">
                Мы — команда энтузиастов, увлеченных чаем и стремящихся поделиться своей любовью с вами.
                Каждый из нас — эксперт в своей области, и вместе мы создаем уникальный опыт для наших клиентов.
            </p>
        </section>
    </main>
@endsection
