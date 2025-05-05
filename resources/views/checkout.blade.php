@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="{{ route('cart.index') }}"
                class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Вернуться в корзину
            </a>
            <h1 class="text-3xl font-semibold"> Оформить заказ </h1>
        </div>
    </div>

    <main class="container mx-auto px-8">

        <!-- Общий контейнер для левой и правой части -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Левая колонка: Информация о пользователе -->
            <div>
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 font-playfair">Информация о доставке</h2>
                    <div>
                        <p class="text-gray-700 font-medium mb-2">Имя: Иван Иванов</p>
                        <p class="text-gray-700 font-medium mb-2">Email: ivan.ivanov@example.com</p>
                        <p class="text-gray-700 font-medium mb-2">Телефон: +7 999 999-99-99</p>
                    </div>
                    <div class="flex items-center mb-4">
                        <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.94l-4.95-4.95a7 7 0 010-9.9zm9.8 3.19a1 1 0 00-1.41 0l-4 4a1 1 0 001.41 1.41l4-4a1 1 0 000-1.41z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-gray-700 font-medium">Адрес доставки:</p>
                    </div>
                    @if ($delivery)
                        <div id="address-block" class="rounded-md p-3 text-gray-700">
                            <p>Улица: {{ $delivery->street }}</p>
                            <p>Город: {{ $delivery->city }}</p>
                            <p>Индекс: {{ $delivery->postal_code }}</p>
                        </div>
                    @else
                        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                            <p>Пожалуйста, <a href="{{ route('profile.index') }}"
                                    class="underline font-semibold hover:text-red-800">заполните данные для доставки</a>
                                перед оформлением заказа.</p>
                        </div>
                    @endif

                </div>
            </div>

            @php $total = 0; @endphp
            <!-- Правая колонка: Все остальные элементы -->
            <div>
                <!-- Объединенный блок: Ваш заказ, Способ оплаты, Кнопка -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 font-playfair">Ваш заказ</h2>
                    <!-- Список товаров -->
                    @if ($cart && $cart->items->count())
                        @foreach ($cart->items as $cartItem)
                            @php
                                $product = $cartItem->product;
                                $subtotal = $product->price * $cartItem->quantity;
                                $total += $subtotal;
                            @endphp
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <div class="flex gap-4">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-12">
                                    <div>
                                        <p class="text-gray-800
                                        font-medium">
                                            {{ $product->name }}</p>
                                        <p class="text-gray-600 text-sm">Количество: {{ $cartItem->quantity }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-900 font-bold">{{ $subtotal }} рублей</p>
                            </div>
                        @endforeach

                        <h2 class="text-xl font-semibold text-gray-800 mb-4 mt-4 font-playfair">Способ оплаты</h2>

                        <form action="{{ route('order.store') }}" method="POST" id="order-form" class="w-full">
                            @csrf
                            <!-- Варианты оплаты (радиокнопки) -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    <input type="radio" name="payment_method" value="card" class="mr-2"> Оплата картой
                                </label>

                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    <input type="radio" name="payment_method" value="cash" class="mr-2"> Оплата
                                    наличными
                                </label>
                            </div>

                            @if ($delivery)
                                <button type="submit"
                                    class="bg-green-700 w-full hover:bg-green-800 text-white py-3 px-6 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 text-center">
                                    Оформить заказ
                                </button>
                            @else
                                <button disabled
                                    class="bg-gray-400 text-white py-3 px-6 rounded opacity-50 cursor-not-allowed text-center w-full">
                                    Оформить заказ
                                </button>
                            @endif
                        </form>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection
