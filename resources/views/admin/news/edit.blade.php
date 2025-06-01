@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="{{ route('news') }}"
                class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-all duration-300">
   <svg class="-ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
      fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd"
         d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
         clip-rule="evenodd" />
                </svg>
                На странице новостей
            </a>
            <h1 class="text-3xl font-semibold">Редактирование новости</h1>
        </div>
    </div>

    <main class="container mx-auto px-8 mb-4">
        <!-- Блок товара -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">

            <div class="bg-white shadow-md rounded-lg p-8">
                <form method="POST" action="{{ route('news.update', $news) }}" enctype="multipart/form-data">
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
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Изображение
                            новости:</label>
                        <input type="file" id="image" name="image"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <img src="{{ asset('storage/' . $news->image) }}" alt="Image"
                            class="mt-2 w-32 h-32 object-cover">
                    </div>

                    <!-- Название товара -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Название новости:</label>
                        <input type="text" id="name" name="title" value="{{ $news->title }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Описание товара -->
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание
                            новости:</label>
                        <textarea id="description" name="content" rows="4"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $news->content }}</textarea>
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

        <script>
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
