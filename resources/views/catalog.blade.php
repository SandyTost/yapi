@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="index.html"
                class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Вернуться на главную
            </a>
            <h1 class="text-3xl font-semibold">Каталог</h1>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/4 px-4">
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <form method="GET" action="{{ route('catalog') }}">

                        <!-- Поиск товаров -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold mb-2 pb-1 border-b-2 border-black">Поиск товаров</h3>
                            <input type="text" name="search"
                                class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm"
                                placeholder="Название или описание" value="{{ request('search') }}">
                        </div>

                        <!-- Фильтр "Тип чая" -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold mb-2 pb-1 border-b-2 border-black">Тип чая</h3>
                            @foreach ($teaTypes as $type)
                                <label class="block text-sm">
                                    <input type="radio" name="tea-type" value="{{ $type->id }}"
                                        class="mr-2 rounded-full" {{ request('tea-type') == $type->id ? 'checked' : '' }}>
                                    {{ $type->name }}
                                </label>
                            @endforeach
                        </div>

                        <!-- Фильтр "Регион происхождения" -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold mb-2 pb-1 border-b-2 border-black">Регион происхождения</h3>
                            @foreach ($originRegions as $region)
                                <label class="block text-sm">
                                    <input type="radio" name="origin" value="{{ $region->id }}"
                                        class="mr-2 rounded-full" {{ request('origin') == $region->id ? 'checked' : '' }}>
                                    {{ $region->name }}
                                </label>
                            @endforeach
                        </div>

                        <!-- Фильтр "Сорт" -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold mb-2 pb-1 border-b-2 border-black">Сорт</h3>
                            @foreach ($teaVarieties as $variety)
                                <label class="block text-sm">
                                    <input type="radio" name="sort" value="{{ $variety->id }}"
                                        class="mr-2 rounded-full" {{ request('sort') == $variety->id ? 'checked' : '' }}>
                                    {{ $variety->name }}
                                </label>
                            @endforeach
                        </div>

                        <!-- Фильтр "Степень ферментации" -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold mb-2 pb-1 border-b-2 border-black">Степень ферментации</h3>
                            @foreach ($fermentationDegrees as $degree)
                                <label class="block">
                                    <input type="radio" name="fermentation" value="{{ $degree->id }}"
                                        class="mr-2 rounded-full"
                                        {{ request('fermentation') == $degree->id ? 'checked' : '' }}> {{ $degree->name }}
                                </label>
                            @endforeach
                        </div>

                        <!-- Фильтр "Цена" -->
                        <div>
                            <h3 class="text-lg font-semibold mb-2 pb-1 border-b-2 border-black">Цена</h3>
                            <div class="flex items-center">
                                <label for="min-price" class="mr-2">От:</label>
                                <input type="number" name="min-price" id="min-price"
                                    class="w-20 border rounded px-2 py-1 text-sm" value="{{ request('min-price') }}"
                                    placeholder="0">
                                <label for="max-price" class="mx-2">До:</label>
                                <input type="number" name="max-price" id="max-price"
                                    class="w-20 border rounded px-2 py-1 text-sm" value="{{ request('max-price') }}"
                                    placeholder="1000">
                            </div>
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded w-full mt-5">
                                Применить
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-full md:w-3/4 px-4">
                <!-- Проверка наличия товаров -->
                @if ($products->isEmpty())
                    <div class="text-center text-lg font-semibold text-gray-700">
                        Товаров нет
                    </div>
                @else
                    <!-- Карточки товаров -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($products as $product)
                            <div class="bg-white rounded-lg shadow p-4">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    class="w-full object-contain mx-auto">
                                <h3 class="text-lg font-semibold text-center">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-center">{{ $product->description }}</p>
                                <p class="text-green-600 font-bold text-center mt-1">{{ $product->price }} рублей</p>
                                <a href="{{ route('product.show', $product->id) }}"
                                    class="inline-block bg-green-700 hover:bg-green-800 text-center text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 mt-3 mb-3 w-full">
                                    Купить
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Пагинация -->
                    <div class="mt-6 flex justify-center">
                        <div class="inline-flex space-x-2">
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
