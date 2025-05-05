<header class="sticky top-0 bg-white shadow py-4 relative z-10">
    <div class="container mx-auto px-8 mt-2 mb-2">
        <nav class="flex items-center justify-between">

            <div>
                <a href="{{ route('index') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="Логотип" class="h-4">
                </a>
            </div>

            <!-- Централизованное меню -->
            <div class="absolute left-1/2 transform -translate-x-1/2 hidden md:flex items-center justify-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('catalog') }}" class="text-black hover:text-gray-700">Каталог</a>
                    <a href="{{ route('news') }}" class="text-black hover:text-gray-700">Новости</a>
                    <a href="{{ route('about') }}" class="text-black hover:text-gray-700">О нас</a>
                    <a href="{{ route('contact') }}" class="text-black hover:text-gray-700">Контакты</a>
                </div>
            </div>

            <!-- Иконки -->
            <div class="hidden md:flex items-center space-x-5">
                <a href="{{ route('cart.index') }}" class="text-black text-2xl hover:text-gray-700"><i
                        class="fas fa-shopping-cart"></i></a>
                <a href="{{ route('profile.index') }}" class="text-black text-2xl hover:text-gray-700"><i
                        class="fas fa-user"></i></a>
            </div>

            <!-- Кнопка меню -->
            <button id="menu-toggle" class="md:hidden text-black focus:outline-none relative ">
                <i class="fas fa-bars"></i>
            </button>

        </nav>
    </div>

    <!-- Мобильное меню (скрыто) -->
    <div id="mobile-menu"
        class="md:hidden bg-white py-2 px-8 transform translate-y-[-100%] transition-transform duration-300 ease-in-out absolute top-full left-0 w-full z-10">
        <div class="flex flex-col items-center space-y-2">
            <a href="{{ route('catalog') }}" class="text-black hover:text-gray-700">Каталог</a>
            <a href="{{ route('news') }}" class="text-black hover:text-gray-700">Новости</a>
            <a href="{{ route('about') }}" class="text-black hover:text-gray-700">О нас</a>
            <a href="{{ route('contact') }}" class="text-black hover:text-gray-700">Контакты</a>

            <!-- Иконки в мобильном меню -->
            <div class="flex items-center space-x-4 mt-2">
                <a href="{{ route('cart.index') }}" class="text-black hover:text-gray-700"><i
                        class="fas fa-shopping-cart"></i></a>
                <a href="{{ route('profile.index') }}" class="text-black hover:text-gray-700"><i
                        class="fas fa-user"></i></a>
            </div>
        </div>
    </div>
</header>
