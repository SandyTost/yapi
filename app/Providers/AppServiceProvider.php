<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Illuminate\Pagination\Paginator; // Добавьте этот импорт

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ваш существующий код для Socialite
        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('yandex', \SocialiteProviders\Yandex\Provider::class);
        });

        // Добавьте это для кастомной пагинации
        Paginator::defaultView('vendor.pagination.custom'); // Использует ваш кастомный шаблон
        Paginator::defaultSimpleView('vendor.pagination.simple-custom'); // Для simplePaginate()
        
        // ИЛИ, если хотите использовать Bootstrap стиль без текста:
        // Paginator::useBootstrap();
    }
}