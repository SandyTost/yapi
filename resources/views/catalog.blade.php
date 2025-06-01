@extends('layouts.app')

@section('content')
    <div class="flex flex-col min-h-screen">
        <div class="container mx-auto px-4 p-4">
            <div class="w-full p-4 flex items-center justify-between">
                <a href="{{ route('index') }}" 
   class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-all duration-300">
   <svg class="-ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
      fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd"
         d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
         clip-rule="evenodd" />
   </svg>
   <span class="text-sm sm:text-base">Вернуться на главную</span>
</a>
                <h1 class="text-3xl font-semibold">Каталог</h1>
            </div>
        </div>

        <div class="container mx-auto px-4 flex-grow">
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-1/4 px-4">
                    <div class="bg-white rounded-lg shadow p-4 mb-4">
                        <form method="GET" action="{{ route('catalog') }}" id="filter-form">

                            <!-- Поиск товаров -->
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2 pb-1 border-b-2 border-black">Поиск товаров</h3>
                                <input type="text" name="search" id="search"
                                    class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm"
                                    placeholder="Название или описание" value="{{ request('search') }}">
                            </div>

                            <!-- Фильтр "Тип чая" -->
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold mb-2 pb-1 border-b-2 border-black">Тип чая</h3>
                                @foreach ($teaTypes as $type)
                                    <label class="block text-sm">
                                        <input type="radio" name="tea-type" value="{{ $type->id }}"
                                            class="mr-2 rounded-full tea-type-radio" autocomplete="off" 
                                            {{ request('tea-type') == $type->id ? 'checked' : '' }}>
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
                                            class="mr-2 rounded-full origin-radio" autocomplete="off" 
                                            {{ request('origin') == $region->id ? 'checked' : '' }}>
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
                                            class="mr-2 rounded-full sort-radio" autocomplete="off" 
                                            {{ request('sort') == $variety->id ? 'checked' : '' }}>
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
                                            class="mr-2 rounded-full fermentation-radio" autocomplete="off"
                                            {{ request('fermentation') == $degree->id ? 'checked' : '' }}> 
                                        {{ $degree->name }}
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

                            <!-- Кнопка сброса -->
                            <button type="button" onclick="resetAllFilters()" 
                                class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded w-full mt-5">
                                Сбросить все фильтры
                            </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="w-full md:w-3/4 px-4">
                    @if ($products->isEmpty())
                        <div class="text-center text-lg font-semibold text-gray-700">
                            Товаров нет
                        </div>
                    @else
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
                                        Подробнее
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Блок пагинации (фиксированный внизу) -->
        <div class="mt-auto py-4">
            <div class="container mx-auto px-4">
                @if($products->isNotEmpty() && $products->hasPages())
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
    // Функция сброса всех фильтров
    function resetAllFilters() {
        // Сбрасываем текстовые поля
        document.getElementById('search').value = '';
        document.getElementById('min-price').value = '';
        document.getElementById('max-price').value = '';
        
        // Сбрасываем все радио-кнопки
        document.querySelectorAll('.tea-type-radio').forEach(radio => radio.checked = false);
        document.querySelectorAll('.origin-radio').forEach(radio => radio.checked = false);
        document.querySelectorAll('.sort-radio').forEach(radio => radio.checked = false);
        document.querySelectorAll('.fermentation-radio').forEach(radio => radio.checked = false);
        
        // Отправляем форму (это перезагрузит страницу без параметров)
        document.getElementById('filter-form').submit();
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