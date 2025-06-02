<?php

namespace App\Http\Controllers;

use App\Models\{Product, CartItem};
use App\Http\Requests\Cart\{StoreCartRequest, UpdateCartRequest};
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Открытие корзины
     */
    public function index()
    {
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with([
                'product' => function ($query) {
                    $query->withTrashed(); // Загружаем и мягко удаленные товары
                }
            ])
            ->get();

        $total = $cartItems->sum(function ($item) {
            // Считаем только доступные товары
            return $item->product && !$item->product->trashed()
                ? $item->product->price * $item->quantity
                : 0;
        });

        // Проверяем есть ли недоступные товары
        $hasUnavailableItems = $cartItems->contains(function ($item) {
            return !$item->product || $item->product->trashed();
        });

        return view('cart', compact('cartItems', 'total', 'hasUnavailableItems'));
    }

    /**
     * Добавление товара в корзину
     */
    public function store(StoreCartRequest $request)
    {
        $validated = $request->validated();
        $productId = $validated['product_id'];
        $quantity = $validated['quantity'] ?? 1;

        $product = Product::findOrFail($productId);

        if ($product->stock_quantity < $quantity) {
            return back()->with('error', 'Недостаточно товара на складе!');
        }

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock_quantity < $newQuantity) {
                return back()->with('error', 'Недостаточно товара на складе!');
            }
            $cartItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину!');
    }

    /**
     * Обновление количества
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // Загружаем связь product
        $cartItem->load('product');

        if ($request->input('action') === 'increment') {
            if ($cartItem->product->stock_quantity > $cartItem->quantity) {
                $cartItem->increment('quantity');
            } else {
                return back()->with('error', 'Недостаточно товара на складе!');
            }
        } elseif ($request->input('action') === 'decrement') {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                $cartItem->delete();
                return back()->with('success', 'Товар удалён из корзины!');
            }
        }

        return back()->with('success', 'Количество обновлено!');
    }

    /**
     * Удаление товара
     */
    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();
        return back()->with('success', 'Товар удалён из корзины!');
    }

    /**
     * Очистка корзины (при оформлении заказа)
     */
    public function clear()
    {
        CartItem::where('user_id', auth()->id())->delete();
        return back()->with('success', 'Корзина очищена!');
    }

    /**
     * Очистка недоступных товаров
     */
    public function clearUnavailable()
    {
        $deletedCount = CartItem::where('user_id', auth()->id())
            ->whereHas('product', function ($query) {
                $query->onlyTrashed();
            })
            ->orWhereDoesntHave('product')
            ->delete();

        return back()->with('success', "Удалено недоступных товаров: {$deletedCount}");
    }
}
