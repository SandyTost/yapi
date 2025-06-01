@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('admin.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Назад в админ-панель
                </a>
            </div>
            <h1 class="text-3xl font-semibold">Управление заказами</h1>
            <div></div>
        </div>

        <!-- Фильтры -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Фильтры</h2>
            <form action="{{ route('admin.orders') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="w-full md:w-auto">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Статус заказа</label>
                    <select id="status" name="status"
                        class="w-full md:w-48 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="">Все статусы</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>В обработке</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Выполнен</option>
                    </select>
                </div>

                <div class="w-full md:w-auto">
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Дата с</label>
                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                        class="w-full md:w-48 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                </div>

                <div class="w-full md:w-auto">
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Дата по</label>
                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                        class="w-full md:w-48 rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                </div>

                <div class="w-full md:w-auto flex items-end">
                    <button type="submit"
                        class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                        Применить фильтры
                    </button>
                </div>
            </form>
        </div>

        <div class="flex justify-end mb-4 space-x-2">
            {{-- <form action="{{ route('admin.orders.export') }}" method="GET">
                <!-- Передаем параметры фильтрации -->
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if (request('date_from'))
                    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                @endif
                @if (request('date_to'))
                    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                @endif

                <button type="submit"
                    class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Экспорт в Excel
                </button>
            </form> --}}

            <form action="{{ route('admin.orders.export') }}" method="GET">
                <!-- Передаем параметры фильтрации -->
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if (request('date_from'))
                    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                @endif
                @if (request('date_to'))
                    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                @endif
                <input type="hidden" name="detailed" value="1">

                <button type="submit"
                    class="px-4 py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Детальный отчет
                </button>
            </form>
        </div>

        <!-- Таблица заказов -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                № заказа
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Клиент
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Дата
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Сумма
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Статус
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Способ оплаты
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $order->user->name ?? 'Удаленный пользователь' }}<br>
                                    <span class="text-xs text-gray-500">{{ $order->user->email ?? '' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $order->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($order->total_amount, 0, ',', ' ') }} ₽
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($order->status == 'completed')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Выполнен
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            В обработке
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $order->payment_method == 'card' ? 'Карта' : 'Наличные' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('orders.show', $order->id) }}"
                                            class="text-green-900 hover:text-green-900">
                                            Подробнее
                                        </a>
                                        <button type="button"
                                            class="text-green-600 hover:text-green-900 change-status-btn"
                                            data-order-id="{{ $order->id }}"
                                            data-current-status="{{ $order->status }}">
                                            Изменить статус
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Заказы не найдены
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            <div class="px-6 py-4 bg-white border-t border-gray-200">
                {{ $orders->links() }}
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
