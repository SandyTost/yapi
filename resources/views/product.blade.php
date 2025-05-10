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
