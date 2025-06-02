    @extends('layouts.app')

    @section('content')
        <div class="container mx-auto px-4 p-4 flex-grow">
            <div class="w-full p-4 flex items-center justify-between">
                <a href="{{ route('catalog') }}"
                    class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-all duration-300">
                    <svg class="-ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                        Вернуться в каталог
                </a>
                <h1 class="text-3xl font-semibold">Корзина</h1>
            </div>
        </div>

        <main class="container mx-auto px-4 sm:px-6 lg:px-8">

            @if ($hasUnavailableItems)
                <!-- Предупреждение о недоступных товарах -->
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded">
                    <div class="flex items-center justify-between">
                        <div class="flex">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p><strong>Внимание!</strong> В корзине есть товары, которые больше не доступны.</p>
                        </div>
                        <form method="POST" action="{{ route('cart.clear-unavailable') }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                Удалить недоступные
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Блок с товарами -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @forelse ($cartItems as $item)
                        @php
                            $isUnavailable = !$item->product || $item->product->trashed();
                        @endphp
                        <li
                            class="py-4 sm:py-6 px-4 sm:px-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 {{ $isUnavailable ? 'bg-gray-50 opacity-75' : '' }}">
                            <!-- Блок с изображением и информацией о товаре -->
                            <div class="flex items-center w-full sm:w-auto">
                                @if ($item->product)
                                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}"
                                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg mr-3 sm:mr-4 object-cover border border-gray-200 {{ $isUnavailable ? 'grayscale' : '' }}">
                                    <div class="flex-1 min-w-0">
                                        <h3
                                            class="font-semibold text-gray-800 text-base sm:text-lg truncate {{ $isUnavailable ? 'line-through text-gray-500' : '' }}">
                                            {{ $item->product->name }}
                                            @if ($isUnavailable)
                                                <span class="text-red-500 text-sm font-normal">(Товар снят с продажи)</span>
                                            @endif
                                        </h3>
                                        @if (!$isUnavailable)
                                            <p class="text-gray-600 text-sm sm:text-base mt-1">
                                                {{ $item->product->price }} руб.</p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Доступно: {{ $item->product->stock_quantity }} шт.
                                            </p>
                                        @else
                                            <p class="text-red-500 text-sm mt-1">Товар больше не доступен</p>
                                        @endif
                                    </div>
                                @else
                                    <div
                                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg mr-3 sm:mr-4 bg-gray-200 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-500 text-base sm:text-lg truncate line-through">
                                            Товар удален
                                        </h3>
                                        <p class="text-red-500 text-sm mt-1">Товар больше не существует</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Блок управления количеством и удалением -->
                            <div class="flex items-center justify-between w-full sm:w-auto space-x-3 sm:space-x-4">
                                @if (!$isUnavailable)
                                    <!-- Улучшенный блок управления количеством -->
                                    <div class="flex items-center bg-gray-100 rounded-lg p-1">
                                        <form method="POST" action="{{ route('cart.update', $item->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="decrement">
                                            <button type="submit"
                                                class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 rounded-md text-gray-600 hover:bg-gray-200 transition-colors"
                                                aria-label="Уменьшить количество">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="5" y1="12" x2="19" y2="12">
                                                    </line>
                                                </svg>
                                            </button>
                                        </form>

                                        <div
                                            class="w-10 sm:w-12 text-center font-medium text-gray-800 text-sm sm:text-base">
                                            {{ $item->quantity }}
                                        </div>

                                        <form method="POST" action="{{ route('cart.update', $item->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="action" value="increment">
                                            <button type="submit"
                                                class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 rounded-md text-gray-600 hover:bg-gray-200 transition-colors {{ $item->quantity >= $item->product->stock_quantity ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                aria-label="Увеличить количество"
                                                {{ $item->quantity >= $item->product->stock_quantity ? 'disabled' : '' }}>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="12" y1="5" x2="12" y2="19">
                                                    </line>
                                                    <line x1="5" y1="12" x2="19" y2="12">
                                                    </line>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <!-- Для недоступных товаров показываем только количество -->
                                    <div class="flex items-center bg-gray-200 rounded-lg p-1">
                                        <div
                                            class="w-20 sm:w-24 text-center font-medium text-gray-500 text-sm sm:text-base py-2">
                                            {{ $item->quantity }} шт.
                                        </div>
                                    </div>
                                @endif

                                <!-- Кнопка удаления -->
                                <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors"
                                        aria-label="Удалить из корзины">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18"></path>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="py-8 sm:py-12 px-4 sm:px-6 text-center text-gray-500 text-base sm:text-lg">
                            Ваша корзина пуста.
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Итоги корзины и кнопка оформления заказа -->
            <div class="mt-6 sm:mt-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <!-- Итоги корзины -->
                    <div class="flex items-center">
                        <span class="text-xl sm:text-2xl text-gray-700 font-bold">Итого:</span>
                        <span class="text-xl sm:text-2xl font-bold text-gray-800 ml-2">
                            {{ $total }} руб.
                        </span>
                    </div>

                    @if ($cartItems->count() && !$hasUnavailableItems)
                        <!-- Кнопка оформления заказа -->
                        <a href="{{ route('order.index') }}"
                            class="w-full sm:w-auto text-center bg-green-700 hover:bg-green-800 text-white py-2 px-4 sm:py-2 sm:px-6 rounded-md text-base sm:text-lg font-medium transition-colors duration-200">
                            Оформить заказ
                        </a>
                    @elseif($hasUnavailableItems)
                        <!-- Заблокированная кнопка если есть недоступные товары -->
                        <div class="w-full sm:w-auto text-center">
                            <button disabled
                                class="bg-gray-400 text-white py-2 px-4 sm:py-2 sm:px-6 rounded-md text-base sm:text-lg font-medium opacity-50 cursor-not-allowed w-full sm:w-auto">
                                Удалите недоступные товары
                            </button>
                        </div>
                    @endif
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
