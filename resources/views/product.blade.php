@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="{{ route('catalog') }}"
                class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Вернуться в каталог
            </a>
            <h1 class="text-3xl font-semibold"> Чай </h1>
        </div>
    </div>

    <main class="container mx-auto px-8 mb-4">
        <!-- Блок товара -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">

                <!-- Левая колонка: Изображение товара -->
                <div class="p-6 md:p-8">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full">
                </div>

                <!-- Правая колонка: Информация о товаре -->
                <div class="p-6 md:p-8">
                    <!-- Рейтинг -->
                    <div class="flex items-center justify-between mb-2">
                        <h1 class="text-3xl font-semibold text-gray-800 mb-4 font-playfair">{{ $product->name }}</h1>
                        @if (Auth::user() && Auth::user()->role == 'admin')
                            <div class="flex space-x-2">
                                <a href="#" class="text-red-500 hover:text-red-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l-4.898 4.898M5.5 17.5l4.898-4.898m0 0l4.898-4.898M14.5 12a2.5 2.5 0 100-5 2.5 2.5 0 000 5zM3 17.5h2.5M3 12h2.5m13 5h-2.5M18.5 12h-2.5">
                                        </path>
                                    </svg>
                                </a>
                                <a href="#" class="text-red-500 hover:text-red-700">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    <p class="text-gray-700 text-lg mb-6  text-justify">{{ $product->description }}</p>

                    <!-- Как хранить -->
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 font-playfair">Как хранить:</h3>
                        <p class="text-gray-700 text-justify">
                            {{ $product->storageCondition->description ?? 'Нет информации о хранении' }}</p>
                    </div>

                    <!-- Характеристики (как фильтр) -->
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 font-playfair">Характеристики:</h3>
                        <ul>
                            <li class="text-gray-700 mb-1 flex items-center justify-between">
                                <span class="font-medium">Тип чая:</span>
                                <span>{{ $product->teaType->name ?? 'Не указан' }}</span>
                            </li>
                            <li class="text-gray-700 mb-1 flex items-center justify-between">
                                <span class="font-medium">Регион происхождения:</span>
                                <span>{{ $product->originRegion->name ?? 'Не указан' }}</span>
                            </li>
                            <li class="text-gray-700 mb-1 flex items-center justify-between">
                                <span class="font-medium">Сорт:</span>
                                <span>{{ $product->teaVariety->name ?? 'Не указан' }}</span>
                            </li>
                            <li class="text-gray-700 mb-1 flex items-center justify-between">
                                <span class="font-medium">Степень ферментации:</span>
                                <span>{{ $product->fermentationDegree->name ?? 'Не указана' }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <p class="text-2xl font-bold text-gray-900 hover:text-gray-700">{{ $product->price }} рублей</p>
                        <form action="{{ route('cart.store', $product->id) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full">
                                В корзину
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
