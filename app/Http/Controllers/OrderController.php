<?php

namespace App\Http\Controllers;

use App\Models\{Order, OrderItem};
use App\Http\Requests\Order\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Отображение страницы заказа
     */
    public function index()
    {
        $user = auth()->user();
        $delivery = $user->deliveryAddress;

        $cart = $user->cart()->with('items.product')->first();
        return view('checkout', [
            'cart' => $cart,
            'delivery' => $delivery
        ]);
    }

    /**
     * Создание заказа
     */
    public function store(StoreOrderRequest $request)
    {
        $user = auth()->user();
        $cart = $user->cart;

        if (!$user->deliveryAddress || !$cart || $cart->items->isEmpty()) {
            return redirect()->back()->withErrors('Доставка или корзина не заполнены.');
        }
        DB::beginTransaction();
        try {
            // Создание заказа
            $order = Order::create([
                'user_id' => $user->id,
                'delivery_address_id' => $user->deliveryAddress->id,
                'payment_method' => $request->payment_method,
                'total_amount' => $cart->items->sum(fn ($item) => $item->product->price * $item->quantity),
                'status' => 'pending',
            ]);

            // Добавление товаров
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }

            // Очистить корзину
            $cart->items()->delete();

            DB::commit();
            return view('thankyou', compact('order'))->with('success', 'Заказ успешно оформлен.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Ошибка при оформлении заказа: ' . $e->getMessage());
        }
    }

    /**
     * Отображение списка заказов с фильтрацией
     */
    public function admin(Request $request)
    {
        $query = Order::with(['user', 'deliveryAddress']);

        // Фильтр по статусу
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Фильтр по дате
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Сортировка по дате (новые сначала)
        $query->latest();

        // Пагинация
        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Отображение детальной информации о заказе
     */
    public function show(Order $order)
    {
        $order->load([
            'user',
            'deliveryAddress',
            'items.product' => function ($query) {
                $query->withTrashed();
            },
        ]);

        return view('admin.orders.show', compact('order'));
    }


    /**
     * Обновление статуса заказа
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Статус заказа успешно обновлен');
    }
}
