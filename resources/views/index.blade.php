@extends('layouts.app')


@section('content')
    <main class="flex-grow container mx-auto px-8 py-4">
        <section class="flex items-center justify-center py-4 relative">
            <div class="container mx-auto py-16 px-6 relative">

                <img src="{{ asset('img/plantation.png') }}" alt="Фоновое изображение"
                    class="absolute inset-0 w-full h-full object-cover rounded-lg ">
                <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>
                <div class="text-center relative  rounded-lg p-4">
                    <div
                        class="text-7xl md:text-[8rem] leading-none uppercase font-playfair py-2 mt-16 text-white font-bold">
                        TEA BREAK
                    </div>
                    <p class="text-xl leading-relaxed py-14 mb-8 text-white">
                        Мы заботимся о каждой чашке вашего чая: храним его в оптимальных условиях, сотрудничаем
                        с проверенными поставщиками, контролируем качество каждой партии и используем специальные
                        технологии, чтобы отобрать только лучшие чайные листья для вашего наслаждения.
                    </p>
                   <a href="{{ route('catalog') }}"
                        class="inline-block px-8 py-4 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                        Перейти в каталог
                    </a>
                </div>
            </div>
        </section>
        <h2 class="text-4xl font-bold text-center text-gray-800 uppercase font-playfair mt-10">О нашей компании</h2>

        <section class="py-16">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">

                    <!-- Левая сторона -->
                    <div class="flex flex-col justify-center text-center md:text-left">
                        <p class="text-gray-600 mb-8 italic text-lg leading-relaxed text-justify">
                            Мы не просто собираем сорта чая. Мы создаём продукт полного вдохновения.
                        </p>
                        <p class="text-gray-700 mb-8 leading-relaxed text-justify">
                            Наш чай ежедневно дарит моменты умиротворения и вдохновения, помогая вам найти гармонию в
                            каждом дне.
                            Эти небольшие паузы, наполненные теплом и ароматом, складываются в ощущение полноценной
                            жизни.
                            Зная это, мы с удвоенным усердием работаем над тем, чтобы каждый глоток нашего чая приносил
                            вам радость и пользу,
                            ведь наша общая цель – сделать мир чуточку теплее и спокойнее.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-justify">
                            Наша цель – создать современный и удобный интернет-магазин, где вы сможете легко найти и
                            заказать лучшие
                            сорта чая и все необходимое для идеального чаепития.
                            Наша цель – стать вашим надежным проводником в мир чая, чтобы вдохновение и умиротворение
                            были всегда под рукой.
                        </p>
                    </div>

                    <!-- Правая сторона -->
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('img/herbs.jpg') }}" alt="О компании"
                            class="w-full h-full object-cover rounded-lg">
                    </div>

                </div>
            </div>
        </section>

        <h2 class="text-4xl font-bold text-center text-gray-800 uppercase font-playfair">Выбор Наших Клиентов</h2>

        <section class="py-16">
            <div class="container mx-auto px-7">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                    @foreach ($randomProducts as $product)
                        <div class="bg-white rounded-lg shadow p-2">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-40 object-contain mt-2 max-w-[200px] mx-auto">
                            <div class="p-2 flex-grow">
                                <h3 class="text-lg font-semibold text-gray-700 text-center mb-1 font-playfair">
                                    {{ $product->name }}</h3>
                                <p class="text-gray-600 text-center">{{ $product->description }}</p>
                            </div>
                            <div class="p-2 text-center">

                                <form action="{{ route('cart.store', $product->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button
                                        class="py-2 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300 w-full">В
                                        корзину</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        <h2 class="text-4xl font-bold text-center text-gray-800 uppercase font-playfair">Новости</h2>

       <section class="py-16">
    <div class="container mx-auto px-7">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($randomNews->take(3) as $item) <!-- Только первые 3 элемента -->
            <!-- Ваша существующая карточка новости -->
            <div class="relative h-96">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                    class="w-full h-full object-cover rounded-lg">
                <div class="absolute bottom-0 left-0 p-4 w-full flex justify-between items-center bg-black bg-opacity-50 rounded-bl-lg rounded-br-lg">
                    <span class="text-white text-xl font-playfair">{{ $item->title }}</span>
                    <a href="{{ route('news') }}">
                        <button class="py-2 px-5 bg-green-700 hover:bg-green-800 text-white rounded-md transition-colors duration-300">
                            Подробнее
                        </button>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
</section>
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
