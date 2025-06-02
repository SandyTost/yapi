<?php

use App\Http\Controllers\{
    MainController,
    ProfileController,
    ProductController,
    FermentationDegreeController,
    TeaVarietyController,
    OriginRegionController,
    TeaTypeController,
    CartController,
    OrderController,
    NewsController
};
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/news', 'news')->name('news');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/admin', 'admin')->middleware(IsAdmin::class)->name('admin.index');
    Route::get('/orders/export', 'export')->middleware(IsAdmin::class)->name('admin.orders.export');
});


Route::middleware(IsAdmin::class)->group(function () {

    Route::controller(NewsController::class)->group(function () {
        Route::get('/news/create', 'create')->name('news.create');
        Route::post('/news/store', 'store')->name('news.store');
        Route::delete('/news/destroy/{news}', 'destroy')->name('news.destroy');
        Route::get('/news/edit/{news}', 'edit')->name('news.edit');
        Route::patch('/news/update/{news}', 'update')->name('news.update');
    });

    Route::controller(TeaTypeController::class)->group(function () {
        Route::post('/type', 'store')->name('type.store');
        Route::delete('/type/{teaType}/destroy', 'destroy')->name('type.destroy');
        Route::patch('/type/{teaType}/update', 'update')->name('type.update');
        Route::post('/type/{teaType}/restore', 'restore')->name('type.restore');
    });

    Route::controller(OriginRegionController::class)->group(function () {
        Route::post('/region', 'store')->name('region.store');
        Route::delete('/region/{originRegion}/destroy', 'destroy')->name('region.destroy');
        Route::patch('/region/{originRegion}/update', 'update')->name('region.update');
        Route::post('/region/{originRegion}/restore', 'restore')->name('region.restore');
    });

    Route::controller(TeaVarietyController::class)->group(function () {
        Route::post('/variety', 'store')->name('variety.store');
        Route::delete('/variety/{teaVariety}/destroy', 'destroy')->name('variety.destroy');
        Route::patch('/variety/{teaVariety}/update', 'update')->name('variety.update');
        Route::post('/variety/{teaVariety}/restore', 'restore')->name('variety.restore');
    });

    Route::controller(FermentationDegreeController::class)->group(function () {
        Route::post('/fermentation', 'store')->name('fermentation.store');
        Route::delete('/fermentation/{fermentationDegree}/destroy', 'destroy')->name('fermentation.destroy');
        Route::patch('/fermentation/{fermentationDegree}/update', 'update')->name('fermentation.update');
        Route::post('/fermentation/{fermentationDegree}/restore', 'restore')->name('fermentation.restore');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('products/create', 'create')->name('products.create');
        Route::get('products/{product}/edit', 'edit')->name('products.edit');
        Route::patch('products/{product}', 'update')->name('product.update');
        Route::post('products', 'store')->name('products.store');
        Route::delete('products/{product}', 'destroy')->name('products.destroy');
        Route::post('products/{product}/restore', 'restore')->name('products.restore');
    });
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/catalog', 'index')->name('catalog');
    Route::get('products/{product}', 'show')->name('product.show');
});

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::post('/cart/add/{product}', 'store')->name('cart.store');
        Route::patch('/cart/update/{cartItem}', 'update')->name('cart.update');
        Route::delete('/cart/remove/{cartItem}', 'destroy')->name('cart.remove');
        Route::delete('/cart/clear-unavailable', 'clearUnavailable')->name('cart.clear-unavailable');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::get('/order', 'index')->name('order.index');
        Route::post('/order', 'store')->name('order.store');
        Route::get('/orders', 'admin')->name('admin.orders');
        Route::get('/orders/{order}', 'show')->name('orders.show');
        Route::patch('/orders/{order}/status', 'updateStatus')->name('orders.status');
    });
});

require __DIR__ . '/auth.php';
