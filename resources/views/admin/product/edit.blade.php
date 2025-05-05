@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="{{ route('admin.index') }}"
                class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                В админ-панель
            </a>
            <h1 class="text-3xl font-semibold">Редактирование товара</h1>
        </div>
    </div>

    <main class="container mx-auto px-8 mb-4">
        <!-- Блок товара -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">

            <div class="bg-white shadow-md rounded-lg p-8">
                <form method="POST" action="{{ route('product.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Изображение товара -->
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Изображение товара:</label>
                        <input type="file" id="image" name="image"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <img src="{{ asset($product->image) }}" alt="Image" class="mt-2 w-32 h-32 object-cover">
                    </div>

                    <!-- Название товара -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Название товара:</label>
                        <input type="text" id="name" name="name" value="{{ $product->name }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Описание товара -->
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание товара:</label>
                        <textarea id="description" name="description" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $product->description }}</textarea>
                    </div>

                    <!-- Тип чая -->
                    <div class="mb-4">
                        <label for="tea_type" class="block text-gray-700 text-sm font-bold mb-2">Тип чая:</label>
                        <select id="tea_type" name="tea_type"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($teaTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ $type->id == $product->tea_type_id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Регион происхождения -->
                    <div class="mb-4">
                        <label for="origin" class="block text-gray-700 text-sm font-bold mb-2">Регион
                            происхождения:</label>
                        <select id="origin" name="origin"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($originRegions as $region)
                                <option value="{{ $region->id }}"
                                    {{ $region->id == $product->origin_region_id ? 'selected' : '' }}>{{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Сорт -->
                    <div class="mb-4">
                        <label for="sort" class="block text-gray-700 text-sm font-bold mb-2">Сорт:</label>
                        <input type="text" id="sort" name="sort" value="{{ $product->tea_variety_id }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Степень ферментации -->
                    <div class="mb-4">
                        <label for="fermentation" class="block text-gray-700 text-sm font-bold mb-2">Степень
                            ферментации:</label>
                        <select id="fermentation" name="fermentation"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($fermentationDegrees as $degree)
                                <option value="{{ $degree->id }}"
                                    {{ $degree->id == $product->fermentation_degree_id ? 'selected' : '' }}>
                                    {{ $degree->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Цена -->
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Цена:</label>
                        <input type="number" id="price" name="price" value="{{ $product->price }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Условия хранения -->
                    <div class="mb-4">
                        <label for="storage" class="block text-gray-700 text-sm font-bold mb-2">Условия хранения:</label>
                        <textarea id="storage" name="storage" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $product->storage_condition_id }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="inline-block bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline">Сохранить
                            изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
