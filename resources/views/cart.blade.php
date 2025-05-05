@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4 flex-grow">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="{{ route('catalog') }}"
                class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Вернуться в каталог
            </a>
            <h1 class="text-3xl font-semibold">Корзина</h1>
        </div>
    </div>

    <main class="container mx-auto px-8">
        <!-- Блок с товарами -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @forelse ($cart->items as $item)
                    <li class="py-6 px-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}"
                                class="w-20 h-20 rounded-lg mr-4 object-cover border border-gray-200">
                            <div>
                                <h3 class="font-semibold text-gray-800 text-lg">{{ $item->product->name }}</h3>
                                <p class="text-gray-600 mt-1">{{ number_format($item->product->price, 0, '.', ' ') }} руб.
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Улучшенный блок управления количеством -->
                            <div class="flex items-center bg-gray-100 rounded-lg p-1">
                                <form method="POST" action="{{ route('cart.update', $item->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="decrement">
                                    <button type="submit"
                                        class="flex items-center justify-center w-8 h-8 rounded-md text-gray-600 hover:bg-gray-200 transition-colors"
                                        aria-label="Уменьшить количество">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Неизменяемый инпут с количеством -->
                                <div class="w-12 text-center font-medium text-gray-800">
                                    {{ $item->quantity }}
                                </div>

                                <form method="POST" action="{{ route('cart.update', $item->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="increment">
                                    <button type="submit"
                                        class="flex items-center justify-center w-8 h-8 rounded-md text-gray-600 hover:bg-gray-200 transition-colors"
                                        aria-label="Увеличить количество">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Улучшенная кнопка удаления -->
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors"
                                    aria-label="Удалить из корзины">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
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
                    <li class="py-12 px-6 text-center text-gray-500 text-lg">Ваша корзина пуста.</li>
                @endforelse
            </ul>
        </div>

        @php
            $total = $cart?->items->sum(fn($item) => $item->product->price * $item->quantity) ?? 0;
        @endphp

        <div><!-- Итоги корзины и кнопка оформления заказа -->
            <div class="mt-8 flex items-center justify-between md:justify-end flex-wrap">
                <!-- Итоги корзины -->
                <div class="flex items-center mb-2 md:mb-0 mr-6 baseline">
                    <span class="text-2xl text-gray-700 font-bold">Итого:</span>
                    <span class="text-2xl font-bold text-gray-800 ml-2">{{ number_format($total, 0, '.', ' ') }}
                        руб.</span>
                </div>

                @if ($cart && $cart->items->count())
                    <!-- Кнопка -->
                    <a href="{{ route('order.index') }}"
                        class="inline-block bg-green-700 hover:bg-green-800 text-white py-2 px-6 rounded-md text-lg font-medium transition-colors duration-200">
                        Оформить заказ
                    </a>
                @endif
            </div>
        </div>
    </main>
@endsection
