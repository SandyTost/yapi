@extends('layouts.app')


@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <div>

                <a href="{{ route('index') }}"
                    class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-all duration-300">
   <svg class="-ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
      fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd"
         d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
         clip-rule="evenodd" />
                    </svg>
                    Вернуться на главную
                </a>
                @if (Auth::user() && Auth::user()->role == 'admin')
                    <a href="{{ route('news.create') }}"
                        class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-all duration-300">
   <svg class="-ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
      fill="currentColor" aria-hidden="true">
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
    </div>
    <main class="flex-grow container mx-auto px-8 py-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach ($news as $item)
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                    <!-- Изображение -->
                    <img src="{{ asset('storage/' . $item->image) }}" alt="Новый сорт чая: &quot;Золотой Дракон&quot;"
                        class="w-full h-56 object-cover">
                    <!-- Контент -->
                    <div class="p-4 sm:p-6 flex flex-col flex-grow">
                        <!-- Заголовок -->
                        <h2
                            class="text-xl font-semibold text-gray-800 mb-2 hover:text-green-600 transition-colors duration-200 font-playfair">
                            {{ $item->title }}
                        </h2>
                        <!-- Описание -->
                        <p class="text-gray-700 leading-relaxed mb-3 flex-grow text-justify">
                            {{ $item->content }}
                        </p>
                        @if (Auth::user() && Auth::user()->role == 'admin')
                            <p class="text-gray-700 leading-relaxed mb-3 flex-grow text-justify">
                                Добавил новость: <b>{{ $item->user->email }}</b>
                            </p>
                            <div class="flex flex-start gap-3">
                                <a href="{{ route('news.edit', $item) }}">
                                    <button type="button"
                                        class="inline-flex w-max items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                                        Редактировать
                                    </button>
                                </a>
                                <form action="{{ route('news.destroy', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex w-max items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors duration-300"
                                        onclick="return confirm('Вы уверены, что хотите удалить эту новость?')">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
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
