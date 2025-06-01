@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('admin.orders') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    К списку заказов
                </a>
            </div>
            <h1 class="text-3xl font-semibold">Заказ #{{ $order->id }}</h1>
            <div>
                <button type="button"
                    class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300 change-status-btn"
                    data-order-id="{{ $order->id }}" data-current-status="{{ $order->status }}">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Изменить статус
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Информация о заказе -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4 pb-2 border-b">Информация о заказе</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Дата заказа:</p>
                            <p class="font-medium">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Статус:</p>
                            <p>
                                @if ($order->status == 'completed')
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Выполнен
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        В обработке
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Способ оплаты:</p>
                            <p class="font-medium">
                                {{ $order->payment_method == 'card' ? 'Банковская карта' : 'Наличными при получении' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Общая сумма:</p>
                            <p class="font-medium text-lg text-green-700">
                                {{ number_format($order->total_amount, 0, ',', ' ') }} ₽</p>
                        </div>
                    </div>
                </div>

                <!-- Товары в заказе -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4 pb-2 border-b">Товары в заказе</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Товар
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Цена
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Количество
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Сумма
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 object-cover"
                                                        src="{{ asset($item->product->image ?? '/images/placeholder.jpg') }}"
                                                        alt="{{ $item->product->name ?? 'Товар' }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item->product->name ?? 'Товар недоступен' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ number_format($item->price, 0, ',', ' ') }} ₽
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $item->quantity }} шт.
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Всего: {{ $order->items->sum('quantity') }} шт.
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-700">
                                        {{ number_format($order->total_amount, 0, ',', ' ') }} ₽
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Информация о клиенте и доставке -->
            <div class="md:col-span-1">
                <!-- Информация о клиенте -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4 pb-2 border-b">Информация о клиенте</h2>

                    @if ($order->user)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Имя:</p>
                            <p class="font-medium">{{ $order->user->name }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Email:</p>
                            <p class="font-medium">{{ $order->user->email }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Телефон:</p>
                            <p class="font-medium">{{ $order->user->phone }}</p>
                        </div>
                    @else
                        <p class="text-gray-500">Информация о пользователе недоступна</p>
                    @endif
                </div>

                <!-- Информация о доставке -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4 pb-2 border-b">Адрес доставки</h2>

                    @if ($order->deliveryAddress)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Город:</p>
                            <p class="font-medium">{{ $order->deliveryAddress->city }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Улица, дом:</p>
                            <p class="font-medium">{{ $order->deliveryAddress->street }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-1">Почтовый индекс:</p>
                            <p class="font-medium">{{ $order->deliveryAddress->postal_code }}</p>
                        </div>
                    @else
                        <p class="text-gray-500">Информация о доставке недоступна</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для изменения статуса -->
    <div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Изменить статус заказа</h3>
            <form id="changeStatusForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="new_status" class="block text-sm font-medium text-gray-700 mb-1">Новый статус</label>
                    <select id="new_status" name="status"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="pending">В обработке</option>
                        <option value="completed">Выполнен</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelStatusChange"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition-colors duration-300">
                        Отмена
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusModal = document.getElementById('statusModal');
            const changeStatusForm = document.getElementById('changeStatusForm');
            const newStatusSelect = document.getElementById('new_status');
            const cancelBtn = document.getElementById('cancelStatusChange');

            // Открытие модального окна
            document.querySelectorAll('.change-status-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-order-id');
                    const currentStatus = this.getAttribute('data-current-status');

                    // Устанавливаем текущий статус в селекте
                    newStatusSelect.value = currentStatus;

                    // Устанавливаем URL для формы
                    changeStatusForm.action = `/orders/${orderId}/status`;

                    // Показываем модальное окно
                    statusModal.classList.remove('hidden');
                });
            });

            // Закрытие модального окна
            cancelBtn.addEventListener('click', function() {
                statusModal.classList.add('hidden');
            });

            // Закрытие по клику вне модального окна
            statusModal.addEventListener('click', function(e) {
                if (e.target === statusModal) {
                    statusModal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
