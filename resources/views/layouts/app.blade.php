<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Break</title>
    <link rel="icon" href="{{ asset('img/Anna.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        /* Позиционирование для уведомлений */
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            max-width: 300px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-out, fadeOut 0.5s ease-in 3s forwards;
        }

        /* Анимации появления и исчезновения уведомлений */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateY(10px);
            }
        }
    </style>
</head>

<body class="flex flex-col min-h-screen bg-gray-100 font-montserrat">

    @include('components.header')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('components.footer')

    <div id="toast-container" class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Проверка наличия сообщений об ошибках или успешных операциях в сессии
            @if (session('error'))
                showToast('error', "{{ session('error') }}");
            @elseif (session('success'))
                showToast('success', "{{ session('success') }}");
            @elseif (session('warning'))
                showToast('warning', "{{ session('warning') }}");
            @endif
        });

        function showToast(type, message) {
            const toastContainer = document.getElementById('toast-container');

            let toast = document.createElement('div');
            toast.classList.add('toast', 'flex', 'items-center', 'gap-3');

            let icon = '';
            let bgColor = '';
            let textColor = '';

            if (type === 'success') {
                bgColor = 'bg-green-100';
                textColor = 'text-green-500';
                icon = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>`;
            } else if (type === 'error') {
                bgColor = 'bg-red-100';
                textColor = 'text-red-500';
                icon = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                        </svg>`;
            } else if (type === 'warning') {
                bgColor = 'bg-orange-100';
                textColor = 'text-orange-500';
                icon = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                        </svg>`;
            }

            toast.innerHTML = `
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 ${bgColor} rounded-lg">
                    ${icon}
                </div>
                <div class="text-sm font-normal ${textColor}">${message}</div>
                <button class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5" onclick="this.parentElement.remove()">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            `;
            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 5000);
        }
    </script>

</body>

</html>
