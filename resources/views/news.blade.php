@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('index') }}"
                    class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-all duration-300">
                    <svg class="-ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Вернуться на главную
                </a>
                @if (Auth::user() && Auth::user()->role == 'admin')
                    <a href="{{ route('news.create') }}"
                        class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-all duration-300">
                        <svg class="-ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Добавить новость
                    </a>
                @endif
            </div>
            <h1 class="text-3xl font-semibold"> Новости </h1>
        </div>

        <!-- Панель сортировки -->
        <div class="w-full px-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        <span class="text-gray-700 font-medium">Сортировка:</span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                        <!-- Выбор поля сортировки -->
                        <div class="relative">
                            <select id="sortField"
                                class="appearance-none bg-white border border-gray-300 rounded-md px-4 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                <option value="created_at" {{ $sortBy == 'created_at' ? 'selected' : '' }}>По дате создания
                                </option>
                                <option value="updated_at" {{ $sortBy == 'updated_at' ? 'selected' : '' }}>По дате
                                    обновления</option>
                                <option value="title" {{ $sortBy == 'title' ? 'selected' : '' }}>По названию</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Кнопки направления сортировки -->
                        <div class="flex bg-gray-100 rounded-md p-1">
                            <button type="button" id="sortDesc"
                                class="flex items-center px-3 py-1.5 text-sm font-medium rounded transition-all duration-200 {{ $sortOrder == 'desc' ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-gray-800' }}">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                                Новые
                            </button>
                            <button type="button" id="sortAsc"
                                class="flex items-center px-3 py-1.5 text-sm font-medium rounded transition-all duration-200 {{ $sortOrder == 'asc' ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-gray-800' }}">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                Старые
                            </button>
                        </div>

                        <!-- Индикатор количества новостей -->
                        <div class="text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-md">
                            Всего: <span class="font-semibold text-gray-700">{{ count($news) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="flex-grow container mx-auto px-8 py-4">
        <!-- Анимация загрузки -->
        <div id="loadingSpinner" class="hidden fixed inset-0 bg-black bg-opacity-20 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 flex items-center gap-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-700"></div>
                <span class="text-gray-700">Загрузка...</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" id="newsGrid">
            @foreach ($news as $item)
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col transform hover:-translate-y-1">
                    <!-- Изображение -->
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                            class="w-full h-56 object-cover transition-transform duration-300 hover:scale-105">
                        <!-- Дата создания -->
                        <div class="absolute top-3 right-3 bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs">
                            {{ $item->created_at->format('d.m.Y') }}
                        </div>
                    </div>

                    <!-- Контент -->
                    <div class="p-4 sm:p-6 flex flex-col flex-grow">
                        <!-- Заголовок -->
                        <h2
                            class="text-xl font-semibold text-gray-800 mb-2 hover:text-green-600 transition-colors duration-200 font-playfair line-clamp-2">
                            {{ $item->title }}
                        </h2>

                        <!-- Описание -->
                        <p class="text-gray-700 leading-relaxed mb-3 flex-grow text-justify line-clamp-3">
                            {{ $item->content }}
                        </p>

                        <!-- Метаинформация -->
                        <div class="text-xs text-gray-500 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $item->created_at->diffForHumans() }}</span>
                        </div>

                        @if (Auth::user() && Auth::user()->role == 'admin')
                            <div class="border-t pt-3 mt-3">
                                <p class="text-sm text-gray-600 mb-3">
                                    Добавил: <span class="font-medium text-gray-800">{{ $item->user->email }}</span>
                                </p>
                                <div class="flex gap-2">
                                    <a href="{{ route('news.edit', $item) }}"
                                        class="flex-1 text-center px-3 py-2 bg-green-700 hover:bg-green-800 text-white text-sm rounded-md transition-colors duration-300">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('news.destroy', $item) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md transition-colors duration-300"
                                            onclick="return confirm('Вы уверены, что хотите удалить эту новость?')">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if (count($news) == 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Новостей пока нет</h3>
                <p class="mt-1 text-sm text-gray-500">Начните с создания первой новости.</p>
            </div>
        @endif
    </main>

    <script>
        // Функция для применения сортировки
        function applySorting() {
            const sortField = document.getElementById('sortField').value;
            const sortOrder = document.querySelector('#sortDesc.bg-white') ? 'desc' : 'asc';

            // Показываем индикатор загрузки
            document.getElementById('loadingSpinner').classList.remove('hidden');

            // Формируем URL с параметрами
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sortField);
            url.searchParams.set('order', sortOrder);

            // Перенаправляем на новый URL
            window.location.href = url.toString();
        }

        // Обработчик изменения поля сортировки
        document.getElementById('sortField').addEventListener('change', applySorting);

        // Обработчики кнопок направления сортировки
        document.getElementById('sortDesc').addEventListener('click', function() {
            // Активируем кнопку "Новые"
            this.classList.add('bg-white', 'text-green-700', 'shadow-sm');
            this.classList.remove('text-gray-600', 'hover:text-gray-800');

            // Деактивируем кнопку "Старые"
            const sortAsc = document.getElementById('sortAsc');
            sortAsc.classList.remove('bg-white', 'text-green-700', 'shadow-sm');
            sortAsc.classList.add('text-gray-600', 'hover:text-gray-800');

            applySorting();
        });

        document.getElementById('sortAsc').addEventListener('click', function() {
            // Активируем кнопку "Старые"
            this.classList.add('bg-white', 'text-green-700', 'shadow-sm');
            this.classList.remove('text-gray-600', 'hover:text-gray-800');

            // Деактивируем кнопку "Новые"
            const sortDesc = document.getElementById('sortDesc');
            sortDesc.classList.remove('bg-white', 'text-green-700', 'shadow-sm');
            sortDesc.classList.add('text-gray-600', 'hover:text-gray-800');

            applySorting();
        });

        // Существующий код для мобильного меню
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuToggle && mobileMenu) {
            mobileMenu.classList.add('hidden');

            menuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('is-active');
            });
        }
    </script>

    <style>
        /* Ограничение количества строк текста */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
