@extends('layouts.app')


@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <div>

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
                @if (Auth::user() && Auth::user()->role == 'admin')
                    <a href="{{ route('news.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7h1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h11.5M7 14h6m-6 3h6m0-10h.5m-.5 3h.5M7 7h3v3H7V7Z" />
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
                                        class="inline-flex w-max items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-300">
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
@endsection
