<?php

namespace App\Http\Controllers;

use App\Models\{Cart, CartItem};
use App\Http\Requests\Cart\{StoreCartRequest, UpdateCartRequest};

class CartController extends Controller
{
    /**
     * Открытие коризны
     */
    public function index()
    {
        $user = auth()->user();

        $cart = $user->cart()->with('items.product')->first();

        return view('cart', [
            'cart' => $cart,
        ]);
    }

    /**
     * Добавление товара в корзину
     */
    public function store(StoreCartRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($item) {
            $item->increment('quantity', $validated['quantity'] ?? 1);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'] ?? 1,
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину!');
    }

    /**
     * Обновление кол-ва товара в корзине
     */
    public function update(UpdateCartRequest $request, CartItem $item)
    {
        $validated = $request->validated();

        if ($request->input('action') === 'increment') {
            $item->increment('quantity');
        } elseif ($request->input('action') === 'decrement' && $item->quantity > 1) {
            $item->decrement('quantity');
        } elseif (isset($validated['quantity'])) {
            $item->update(['quantity' => $validated['quantity']]);
        }

        return back()->with('success', 'Количество товара обновлено!');
    }

    /**
     * Удаление товара из корзины
     */
    public function destroy(CartItem $item)
    {
        $item->delete();

        return back()->with('success', 'Товар удалён из корзины!');
    }
}
