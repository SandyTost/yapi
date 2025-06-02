@extends('layouts.app')


@section('content')
    <div class="container mx-auto px-4 p-4 flex-grow">
        <div class="w-full p-4 flex items-center justify-between">
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
            <h1 class="text-3xl font-semibold"> Личный кабинет </h1>
        </div>
    </div>

    <main class="container mx-auto px-8 flex-grow">
        <div class="md:flex md:space-x-8">

            <div class="md:w-1/2 bg-white shadow-md rounded-lg overflow-hidden flex flex-col h-full">
                <div class="p-6 flex-grow">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2 font-playfair">Информация о пользователе</h2>
                    <div>
                        <p class="text-gray-700 font-medium mb-2">Имя: {{ $user->name }}</p>
                        <p class="text-gray-700 font-medium mb-2">Email: {{ $user->email }}</p>
                        <p class="text-gray-700 font-medium mb-2" id="formatted-phone">Телефон: <span
                                id="masked-phone">{{ $user->phone }}</span></p>
                    </div>
                    <div class="flex items-center mb-4">
                        <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.94l-4.95-4.95a7 7 0 010-9.9zm9.8 3.19a1 1 0 00-1.41 0l-4 4a1 1 0 001.41 1.41l4-4a1 1 0 000-1.41z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-gray-700 font-medium">Адрес доставки: @if (!$delivery)
                                Не указан
                            @endif
                        </p>
                    </div>
                    @if ($delivery)
                        <div id="address-block" class=" rounded-md p-3 text-gray-700 ">

                            <p>Улица: {{ $delivery->street }}</p>
                            <p>Город: {{ $delivery->city }}</p>
                            <p>Индекс: {{ $delivery->postal_code }}</p>
                        </div>
                    @endif
                </div>

                <!-- Кнопки (занимают всю ширину контейнера) -->
                <div class="p-6">
                    <div class="w-full">
                        @if ($user->role == 'admin')
                            <a href="{{ route('admin.index') }}"
                                class="bg-red-500 hover:bg-red-700 text-center text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full mb-2 block">
                                Админ-панель
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button id="logout"
                                class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full">
                                Выход из аккаунта
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <br>

            <!-- Блок с формами для изменения данных -->
            <div class="md:w-1/2 bg-white shadow-md rounded-lg overflow-hidden  md:mb-0">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 font-playfair">Изменить информацию</h3>
                    <form id="edit-profile-form" class="space-y-4" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        {{-- Имя --}}
                        <div class="mb-4">
                            <label for="new-name" class="block text-gray-700 text-sm font-bold mb-2">Новое имя:</label>
                            <input type="text" id="new-name" name="name" value="{{ old('name', $user->name) }}"
                                class="shadow appearance-none border @error('name') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Введите новое имя">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label for="new-email" class="block text-gray-700 text-sm font-bold mb-2">Новый Email:</label>
                            <input type="email" id="new-email" name="email" value="{{ old('email', $user->email) }}"
                                class="shadow appearance-none border @error('email') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Введите новый Email">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Телефон --}}
                        <div class="mb-4">
                            <label for="new-phone" class="block text-gray-700 text-sm font-bold mb-2">Новый номер
                                телефона:</label>
                            <input type="text" id="phone" name="phone"
                                value="{{ old('phone', substr(preg_replace('/[^0-9]/', '', $user->phone), 1)) }}"
                                class="shadow appearance-none border @error('phone') border-red-500 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Введите новый номер телефона">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @if (!$delivery)
                            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                                Пожалуйста, укажите данные для доставки
                            </div>
                        @endif

                        {{-- Улица --}}
                        <div class="mb-4">
                            <label for="street" class="block text-gray-700 text-sm font-bold mb-2">Улица:</label>
                            <input type="text" id="street" name="street"
                                value="{{ old('street', $delivery->street ?? '') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Введите улицу">
                        </div>
                        @error('street')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Город --}}
                        <div class="mb-4">
                            <label for="city" class="block text-gray-700 text-sm font-bold mb-2">Город:</label>
                            <input type="text" id="city" name="city"
                                value="{{ old('city', $delivery->city ?? '') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Введите город">
                        </div>
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Индекс --}}
                        <div class="mb-4">
                            <label for="postal_code" class="block text-gray-700 text-sm font-bold mb-2">Индекс:</label>
                            <input type="text" id="postal_code" name="postal_code"
                                value="{{ old('postal_code', $delivery->postal_code ?? '') }}"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Введите индекс" pattern="\d{6}" maxlength="6" inputmode="numeric" />
                        </div>
                        @error('postal_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <div class="space-x-4">
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200 w-full">
                                Сохранить изменения
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- История заказов -->
        <!-- История заказов -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden my-8">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 font-playfair border-b pb-3">История заказов</h2>

                @if ($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-4 bg-green-700 text-left text-sm font-medium text-white uppercase tracking-wider rounded-tl-lg">
                                        Номер заказа
                                    </th>
                                    <th
                                        class="px-6 py-4 bg-green-700 text-left text-sm font-medium text-white uppercase tracking-wider">
                                        Дата
                                    </th>
                                    <th
                                        class="px-6 py-4 bg-green-700 text-left text-sm font-medium text-white uppercase tracking-wider">
                                        Сумма
                                    </th>
                                    <th
                                        class="px-6 py-4 bg-green-700 text-left text-sm font-medium text-white uppercase tracking-wider">
                                        Статус
                                    </th>
                                    <th
                                        class="px-6 py-4 bg-green-700 text-left text-sm font-medium text-white uppercase tracking-wider rounded-tr-lg">
                                        Действия
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #{{ $order->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $order->created_at->format('d.m.Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <span class="font-medium">{{ $order->total_amount }}
                                                ₽</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($order->status == 'completed')
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Выполнен
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    В обработке
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            <button
                                                class="text-green-700 hover:text-green-900 font-medium flex items-center focus:outline-none transition-colors duration-200"
                                                onclick="toggleOrderDetails({{ $order->id }})">
                                                <span id="button-text-{{ $order->id }}">Подробнее</span>
                                                <svg id="button-icon-down-{{ $order->id }}"
                                                    xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                                <svg id="button-icon-up-{{ $order->id }}"
                                                    xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 hidden"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Детали заказа -->
                                    <tr id="order-details-{{ $order->id }}" class="hidden bg-gray-50">
                                        <td colspan="5" class="px-6 py-4">
                                            <div class="rounded-lg bg-white p-4 shadow-sm border border-gray-200">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <h4 class="font-medium text-gray-700 mb-2">Информация о заказе</h4>
                                                        <div class="space-y-1 text-sm">
                                                            <p><span class="text-gray-500">Дата заказа:</span>
                                                                {{ $order->created_at->format('d.m.Y H:i') }}</p>
                                                            <p><span class="text-gray-500">Способ оплаты:</span>
                                                                @if ($order->payment_method == 'card')
                                                                    Банковская карта
                                                                @else
                                                                    Наличными при получении
                                                                @endif
                                                            </p>
                                                            <p><span class="text-gray-500">Общая сумма:</span> <span
                                                                    class="font-medium">{{ $order->total_amount }}
                                                                    ₽</span></p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-medium text-gray-700 mb-2">Адрес доставки</h4>
                                                        <p class="text-sm">
                                                            {{ $order->deliveryAddress->street ?? 'Не указан' }}</p>
                                                    </div>
                                                </div>

                                                <h4 class="font-medium text-gray-700 mb-2">Товары в заказе</h4>
                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-100">
                                                            <tr>
                                                                <th
                                                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                    Товар</th>
                                                                <th
                                                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                    Цена</th>
                                                                <th
                                                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                    Кол-во</th>
                                                                <th
                                                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                    Сумма</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            @foreach ($order->items as $item)
                                                                <tr>
                                                                    <td
                                                                        class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                                                                        {{ $item->product->name }}
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                                                                        {{ $item->price }} ₽
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                                                                        {{ $item->quantity }} шт.
                                                                    </td>
                                                                    <td
                                                                        class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                                                                        {{ $item->price * $item->quantity }}
                                                                        ₽
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot class="bg-gray-50">
                                                            <tr>
                                                                <td colspan="2"
                                                                    class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">
                                                                </td>
                                                                <td
                                                                    class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-700">
                                                                    Всего: {{ $order->items->sum('quantity') }} шт.
                                                                </td>
                                                                <td
                                                                    class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-700">
                                                                    {{ $order->total_amount }}
                                                                    ₽
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Пагинация -->
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">У вас пока нет заказов</h3>
                        <p class="text-gray-500">Когда вы сделаете заказ, он появится здесь</p>
                        <a href="{{ route('catalog') }}"
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Перейти в каталог
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/inputmask/dist/inputmask.min.js"></script>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var phoneInput = document.getElementById('phone');
            var formattedPhone = document.getElementById('masked-phone');

            // Инициализируем Inputmask с правильными настройками
            var im = new Inputmask("+7 (999) 999-99-99", {
                showMaskOnHover: false,
                clearIncomplete: true,
                autoUnmask: true, // Это важно - сохраняет unmasked value
                removeMaskOnSubmit: true // Удаляет маску при отправке формы
            });

            // Применяем маску на поле ввода
            im.mask(phoneInput);

            // Применяем маску на уже отобразившийся телефон в <p> (в span с id "masked-phone")
            var phoneValue = formattedPhone.textContent || formattedPhone.innerText;

            // Убираем все нецифровые символы и применяем маску
            if (phoneValue && phoneValue.length > 0) {
                phoneValue = phoneValue.replace(/\D/g, ''); // Убираем все нецифровые символы
                formattedPhone.textContent = "+7 (" + phoneValue.substr(1, 3) + ") " + phoneValue.substr(4, 3) +
                    "-" + phoneValue.substr(7, 2) + "-" + phoneValue.substr(9, 2);
            }
        });

        // Функция для переключения видимости дополнительной информации о заказе
        function toggleOrderDetails(orderId) {
            const detailsRow = document.getElementById(`order-details-${orderId}`);
            const buttonText = document.getElementById(`button-text-${orderId}`);
            const iconDown = document.getElementById(`button-icon-down-${orderId}`);
            const iconUp = document.getElementById(`button-icon-up-${orderId}`);

            if (detailsRow.classList.contains('hidden')) {
                detailsRow.classList.remove('hidden');
                buttonText.textContent = 'Скрыть';
                iconDown.classList.add('hidden');
                iconUp.classList.remove('hidden');
            } else {
                detailsRow.classList.add('hidden');
                buttonText.textContent = 'Подробнее';
                iconDown.classList.remove('hidden');
                iconUp.classList.add('hidden');
            }
        }
    </script>
@endsection
