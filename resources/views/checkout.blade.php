@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 p-4">
        <div class="w-full p-4 flex items-center justify-between">
            <a href="{{ route('cart.index') }}"
                class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-all duration-300">
                <svg class="-ml-1 mr-2 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
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
                        <p class="text-gray-700 font-medium mb-2">Имя: {{ Auth::user()->name }}</p>
                        <p class="text-gray-700 font-medium mb-2">Email: {{ Auth::user()->email }}</p>
                        <p class="text-gray-700 font-medium mb-2">
                            Телефон: <span id="phone-output">{{ Auth::user()->phone }}</span>
                        </p>
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

                    @if ($deliveryAddresses && $deliveryAddresses->count())
                        <div class="mb-4">
                            <label for="delivery_address_select" class="block text-sm font-medium text-gray-700 mb-2">
                                Выберите адрес доставки:
                            </label>
                            <select id="delivery_address_select" name="delivery_address_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                                <option value="">-- Выберите адрес --</option>
                                @foreach ($deliveryAddresses as $address)
                                    <option value="{{ $address->id }}"
                                        {{ $currentDelivery && $currentDelivery->id == $address->id ? 'selected' : '' }}>
                                        {{ $address->street }}, {{ $address->city }}, {{ $address->postal_code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('profile.index') }}"
                                class="text-green-600 hover:text-green-700 text-sm font-medium">
                                + Добавить новый адрес
                            </a>
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

            <!-- Правая колонка: Все остальные элементы -->
            <div>
                <!-- Объединенный блок: Ваш заказ, Способ оплаты, Кнопка -->
                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 font-playfair">Ваш заказ</h2>
                    <!-- Список товаров -->
                    @if ($cartItems && $cartItems->count())
                        @foreach ($cartItems as $cartItem)
                            @php
                                $product = $cartItem->product;
                                $subtotal = $product->price * $cartItem->quantity;
                            @endphp
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <div class="flex gap-4">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-12">
                                    <div>
                                        <p class="text-gray-800 font-medium">{{ $product->name }}</p>
                                        <p class="text-gray-600 text-sm">Количество: {{ $cartItem->quantity }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-900 font-bold">{{ number_format($subtotal, 2, ',', ' ') }} руб.</p>
                            </div>
                        @endforeach

                        <!-- Итого -->
                        <div class="flex items-center justify-between py-3 mt-4 border-t-2 border-gray-300">
                            <p class="text-xl font-bold text-gray-800">Итого:</p>
                            <p class="text-xl font-bold text-gray-900">{{ number_format($total, 2, ',', ' ') }} руб.</p>
                        </div>

                        <h2 class="text-xl font-semibold text-gray-800 mb-4 mt-4 font-playfair">Способ оплаты</h2>

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('order.store') }}" method="POST" id="order-form" class="w-full">
                            @csrf

                            <!-- Варианты оплаты (радиокнопки) -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    <input type="radio" name="payment_method" value="card" class="mr-2" required
                                        {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                                    Оплата картой
                                </label>

                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    <input type="radio" name="payment_method" value="cash" class="mr-2" required
                                        {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                                    Оплата наличными
                                </label>
                            </div>

                            @if ($deliveryAddresses && $deliveryAddresses->count())
                                <button type="submit"
                                    class="bg-green-700 w-full hover:bg-green-800 text-white py-3 px-6 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 text-center">
                                    Оформить заказ
                                </button>
                            @else
                                <button disabled
                                    class="bg-gray-400 text-white py-3 px-6 rounded opacity-50 cursor-not-allowed text-center w-full">
                                    Добавьте адрес доставки
                                </button>
                            @endif
                        </form>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">Ваша корзина пуста</p>
                            <a href="{{ route('catalog') }}"
                                class="inline-block mt-4 bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded transition-colors duration-200">
                                Перейти к покупкам
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Форматирование телефона
            const phoneOutput = document.getElementById('phone-output');
            if (phoneOutput) {
                const phoneNumber = phoneOutput.textContent.trim();
                if (/^[78]\d{10}$/.test(phoneNumber)) {
                    const formattedPhone = phoneNumber.replace(
                        /^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/,
                        '+7 ($2) $3-$4-$5'
                    );
                    phoneOutput.textContent = formattedPhone;
                }
            }

            // Обработка выбора адреса
            const addressSelect = document.getElementById('delivery_address_select');
            const orderForm = document.getElementById('order-form');

            if (addressSelect && orderForm) {
                // Синхронизируем select с формой
                addressSelect.addEventListener('change', function() {
                    // Удаляем старое скрытое поле если есть
                    const oldInput = orderForm.querySelector('input[name="delivery_address_id"]');
                    if (oldInput) {
                        oldInput.remove();
                    }

                    // Добавляем новое скрытое поле с выбранным значением
                    if (this.value) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'delivery_address_id';
                        hiddenInput.value = this.value;
                        orderForm.appendChild(hiddenInput);
                    }
                });

                // Если есть предвыбранный адрес, добавляем скрытое поле
                if (addressSelect.value) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'delivery_address_id';
                    hiddenInput.value = addressSelect.value;
                    orderForm.appendChild(hiddenInput);
                }
            }

            // Обработка мобильного меню (если есть)
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');

            if (menuToggle && mobileMenu) {
                mobileMenu.classList.add('hidden');
                menuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    mobileMenu.classList.toggle('is-active');
                });
            }
        });
    </script>
@endsection
