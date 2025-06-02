@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="{{ route('admin.index') }}"
                class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-all duration-300">
                <svg class="-ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                В админ-панель
            </a>
            <h1 class="text-3xl font-semibold">Добавление товара</h1>
        </div>
    </div>

    <main class="container mx-auto px-8 mb-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-white shadow-md rounded-lg p-8">
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Изображение товара -->
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Изображение товара:</label>
                        <input type="file" id="image" name="image"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            onchange="previewImage(event)">
                        <div class="mt-4">
                            <img id="image-preview" src="#" alt="Предпросмотр"
                                class="hidden max-h-64 rounded shadow">
                        </div>
                    </div>

                    <!-- Название товара -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Название товара:</label>
                        <input type="text" id="name" name="name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Введите название товара">
                    </div>

                    <!-- Описание -->
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание:</label>
                        <textarea id="description" name="description" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Введите описание товара"></textarea>
                    </div>

                    <!-- Как хранить -->
                    <div class="mb-4">
                        <label for="storage" class="block text-gray-700 text-sm font-bold mb-2">Как хранить:</label>
                        <textarea id="storage" name="storage" rows="2"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Введите условия хранения"></textarea>
                    </div>

                    <!-- Тип чая -->
                    <div class="mb-4">
                        <label for="tea_type" class="block text-gray-700 text-sm font-bold mb-2">Тип чая:</label>
                        <select id="tea_type" name="tea_type_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($teaTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Регион происхождения -->
                    <div class="mb-4">
                        <label for="origin" class="block text-gray-700 text-sm font-bold mb-2">Регион
                            происхождения:</label>
                        <select id="origin" name="origin_region_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($originRegions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Сорт -->
                    <div class="mb-4">
                        <label for="sort" class="block text-gray-700 text-sm font-bold mb-2">Сорт:</label>
                        <select id="sort" name="tea_variety_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($teaVarieties as $variety)
                                <option value="{{ $variety->id }}">{{ $variety->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Степень ферментации -->
                    <div class="mb-4">
                        <label for="fermentation" class="block text-gray-700 text-sm font-bold mb-2">Степень
                            ферментации:</label>
                        <select id="fermentation" name="fermentation_degree_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($fermentationDegrees as $degree)
                                <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Вес в граммах -->
                    <div class="mb-4">
                        <label for="weight_grams" class="block text-gray-700 text-sm font-bold mb-2">Вес (в
                            граммах):</label>
                        <input type="number" id="weight_grams" name="weight_grams" min="1"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Введите вес товара в граммах">
                    </div>

                    <!-- Количество на складе -->
                    <div class="mb-4">
                        <label for="stock_quantity" class="block text-gray-700 text-sm font-bold mb-2">Количество на
                            складе:</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" min="0"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Введите количество товара на складе" value="0">
                    </div>

                    <!-- Цена -->
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Цена:</label>
                        <input type="number" id="price" name="price" min="1" step="0.01"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Введите цену товара">
                    </div>

                    <!-- Кнопка -->
                    <div class="flex items-center justify-end">
                        <button
                            class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300"
                            type="submit">
                            Добавить товар
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const numberInputs = document.querySelectorAll('input[type="number"]');

            numberInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = '';
                    }
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === '-' || e.key === 'e' || e.key === 'E') {
                        e.preventDefault();
                    }
                });
            });
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('image-preview');
                output.src = reader.result;
                output.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
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
