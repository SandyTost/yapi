@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="{{ route('profile.index') }}"
                class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                В личный кабинет
            </a>
            <h1 class="text-3xl font-semibold"> Админ-панель </h1>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row">
            <!-- Фильтры (слева) -->
            <div class="w-full md:w-1/4 px-4 mb-4">
                <div class="bg-white rounded-lg shadow p-4">

                    <!-- Универсальный фильтр -->
                    @foreach ([
            [
                'title' => 'Тип чая',
                'items' => $teaTypes,
                'name' => 'tea-type',
                'routeStore' => route('type.store'),
                'routePrefix' => 'type',
            ],
            [
                'title' => 'Регион происхождения',
                'items' => $originRegions,
                'name' => 'origin',
                'routeStore' => route('region.store'),
                'routePrefix' => 'region',
            ],
            [
                'title' => 'Сорт',
                'items' => $teaVarieties,
                'name' => 'sort',
                'routeStore' => route('variety.store'),
                'routePrefix' => 'variety',
            ],
            [
                'title' => 'Степень ферментации',
                'items' => $fermentationDegrees,
                'name' => 'fermentation',
                'routeStore' => route('fermentation.store'),
                'routePrefix' => 'fermentation',
            ],
        ] as $filter)
                        <div class="mb-6">
                            <h3
                                class="text-lg font-semibold mb-2 pb-1 border-b-2 border-black flex justify-between items-center">
                                {{ $filter['title'] }}
                            </h3>

                            @foreach ($filter['items'] as $item)
                                <div class="flex justify-between items-center mb-1">
                                    @if ($item->deleted_at)
                                        <label class="text-sm flex-1 line-through text-red-500">
                                            {{ $item->name }}
                                        </label>
                                        <form method="POST"
                                            action="{{ route($filter['routePrefix'] . '.restore', $item->id) }}">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-xs ml-2">
                                                Восстановить
                                            </button>
                                        </form>
                                    @elseif (request()->query('category') == $filter['routePrefix'] && request()->query('edit') == $item->id)
                                        <form method="POST"
                                            action="{{ route($filter['routePrefix'] . '.update', $item->id) }}"
                                            class="flex w-full items-center space-x-2"
                                            id="editForm-{{ $filter['routePrefix'] }}-{{ $item->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="name" value="{{ $item->name }}"
                                                class="border border-gray-300 rounded-md py-1 px-2 text-sm flex-1">
                                            <button type="submit"
                                                class="text-blue-600 hover:text-blue-800 text-xs px-2 py-1 border rounded border-blue-600">
                                                Сохранить
                                            </button>
                                            <a href="#" class="text-gray-500 hover:text-gray-700 text-xs cancel-edit"
                                                data-form-id="editForm-{{ $filter['routePrefix'] }}-{{ $item->id }}">
                                                Отмена
                                            </a>
                                        </form>
                                    @else
                                        <label class="text-sm flex-1">
                                            <input type="radio" name="{{ $filter['name'] }}" class="mr-2 rounded-full">
                                            {{ $item->name }}
                                        </label>

                                        <div class="flex items-center space-x-2">
                                            <button type="button"
                                                class="text-blue-500 hover:text-blue-700 text-xs edit-button"
                                                data-category="{{ $filter['routePrefix'] }}"
                                                data-id="{{ $item->id }}">
                                                Редактировать
                                            </button>
                                            <form method="POST"
                                                action="{{ route($filter['routePrefix'] . '.destroy', $item->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">
                                                    Удалить
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <!-- Форма добавления -->
                            <form method="POST" action="{{ $filter['routeStore'] }}" class="mt-2">
                                @csrf
                                <input type="text" name="name"
                                    class="w-full border border-gray-300 rounded-md py-1 px-2 text-sm mb-2"
                                    placeholder="Новая запись">
                                <button type="submit"
                                    class="bg-green-700 hover:bg-green-800 text-white py-1 px-3 rounded text-sm w-full">
                                    Добавить
                                </button>
                            </form>
                        </div>
                    @endforeach
                    <a href="{{ route('products.create') }}"
                        class="inline-block bg-green-700 hover:bg-green-800 text-center text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full">Добавить
                        товар</a>
                    <div class="mt-6 space-y-3">
                        <a href="{{ route('admin.orders') }}"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-center text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Управление заказами
                        </a>
                    </div>
                </div>
            </div>

            <!-- Список товаров (справа) -->
            <div class="w-full md:w-3/4 px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($products as $product)
                        <div
                            class="bg-white rounded-lg shadow p-4 {{ $product->trashed() ? 'opacity-50 border-2 border-red-400' : '' }}">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                class="w-full object-contain mx-auto h-40 {{ $product->trashed() ? 'grayscale' : '' }}">

                            <h3
                                class="text-lg font-semibold text-center {{ $product->trashed() ? 'line-through text-red-500' : '' }}">
                                {{ $product->name }}
                            </h3>

                            <p class="text-gray-600 text-center {{ $product->trashed() ? 'line-through' : '' }}">
                                {{ $product->description }}
                            </p>

                            <p
                                class="text-green-600 font-bold text-center mt-1 {{ $product->trashed() ? 'line-through' : '' }}">
                                {{ $product->price }} рублей
                            </p>

                            @if ($product->trashed())
                                <p class="text-center text-xs text-red-600 mt-2">Товар удалён</p>
                                <form action="{{ route('products.restore', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-block bg-blue-600 hover:bg-blue-700 text-center text-white py-2 px-4 rounded mt-3 mb-3 w-full">
                                        Восстановить
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="inline-block bg-green-700 hover:bg-green-800 text-center text-white py-2 px-4 rounded mt-3 mb-3 w-full">
                                    Редактировать
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    onsubmit="return confirm('Вы уверены, что хотите удалить этот товар?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-block bg-red-600 hover:bg-red-700 text-center text-white py-2 px-4 rounded mb-3 w-full">
                                        Удалить
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Скрипт для обработки форм -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Обработка кнопок редактирования
            const editButtons = document.querySelectorAll(".edit-button")
            editButtons.forEach((button) => {
                button.addEventListener("click", (e) => {
                    e.preventDefault()
                    const category = button.getAttribute("data-category")
                    const id = button.getAttribute("data-id")

                    // Обновляем URL без перезагрузки страницы
                    const url = new URL(window.location)
                    url.searchParams.set("category", category)
                    url.searchParams.set("edit", id)
                    window.history.pushState({}, "", url)

                    // Перезагружаем страницу без прокрутки вверх
                    location.reload()
                })
            })

            // Обработка кнопок отмены
            const cancelButtons = document.querySelectorAll(".cancel-edit")
            cancelButtons.forEach((button) => {
                button.addEventListener("click", (e) => {
                    e.preventDefault()
                    // Вместо скрытия формы, перенаправляем на ту же страницу без параметров редактирования
                    const url = new URL(window.location)
                    url.searchParams.delete("edit")
                    url.searchParams.delete("category")

                    // Обновляем URL без перезагрузки страницы
                    window.history.pushState({}, "", url)

                    // Перезагружаем страницу без прокрутки вверх
                    location.reload()
                })
            })

            // Обработка отправки форм редактирования
            const editForms = document.querySelectorAll('[id^="editForm-"]')
            editForms.forEach((form) => {
                form.addEventListener("submit", (e) => {
                    const formId = form.id
                    localStorage.setItem("submittedFormId", formId)
                })
            })

            // Проверка, была ли форма отправлена и нужно ли перенаправить
            if (window.location.search.includes("edit=")) {
                const url = new URL(window.location)
                url.searchParams.delete("edit")
                url.searchParams.delete("category")
                window.history.replaceState({}, "", url)
            }
        })
    </script>
@endsection
