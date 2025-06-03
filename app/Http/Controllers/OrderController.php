<?php

namespace App\Http\Controllers;

use App\Models\{Order, OrderItem, CartItem, Product};
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\DeliveryAddress;
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

        // Получаем все адреса пользователя
        $deliveryAddresses = $user->deliveryAddresses()->get();

        // Текущий адрес (последний или указанный как основной)
        $currentDelivery = $user->deliveryAddress;

        $cartItems = CartItem::where('user_id', $user->id)
            ->with('product')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout', [
            'cartItems' => $cartItems,
            'total' => $total,
            'deliveryAddresses' => $deliveryAddresses,
            'currentDelivery' => $currentDelivery
        ]);
    }

    /**
     * Создание заказа
     */
    public function store(StoreOrderRequest $request)
    {
        $user = auth()->user();

        $cartItems = CartItem::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->withErrors(['cart' => 'Ваша корзина пуста.']);
        }

        // Проверяем выбранный адрес доставки
        $deliveryAddressId = $request->delivery_address_id;
        $deliveryAddress = DeliveryAddress::where('id', $deliveryAddressId)
            ->where('user_id', $user->id)
            ->first();

        if (!$deliveryAddress) {
            return redirect()->back()->withErrors(['delivery' => 'Выберите адрес доставки.']);
        }

        // Проверка наличия товаров на складе
        foreach ($cartItems as $item) {
            if (!$item->product) {
                return redirect()->back()->withErrors(['product' => 'Один из товаров в корзине больше не доступен.']);
            }

            if ($item->quantity > $item->product->stock_quantity) {
                return redirect()->back()->withErrors(['stock' => "Товар \"{$item->product->name}\" доступен только в количестве {$item->product->stock_quantity} шт."]);
            }
        }

        DB::beginTransaction();
        try {
            // Создание заказа
            $order = Order::create([
                'user_id' => $user->id,
                'delivery_address_id' => $deliveryAddress->id,
                'payment_method' => $request->payment_method,
                'total_amount' => $cartItems->sum(fn($item) => $item->product->price * $item->quantity),
                'status' => 'pending',
            ]);

            // Добавление товаров в заказ и уменьшение количества на складе
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);

                // Уменьшаем количество товара на складе
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // Очистить корзину
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            return view('thankyou', ['order' => $order])->with('success', 'Заказ успешно оформлен.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Ошибка при создании заказа: ' . $e->getMessage());
            return back()->withErrors(['order' => 'Ошибка при оформлении заказа. Попробуйте еще раз.']);
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
