<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\DeliveryAddress;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Отображение профиля
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Получаем адрес доставки
        $delivery = $user->deliveryAddress ?? null;

        // Получаем заказы пользователя с мягкоудалёнными продуктами и пагинацией по 5 записей
        $orders = $user->orders()
            ->with([
                'items.product' => function ($query) {
                    $query->withTrashed();
                },
                'deliveryAddress'
            ])
            ->latest()
            ->paginate(5);

        return view('profile', [
            'user' => $user,
            'delivery' => $delivery,
            'orders' => $orders,
        ]);
    }


    /**
     * Обновление информации профиля
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        // Очищаем номер телефона от всех символов, кроме цифр
        $phone = preg_replace('/\D/', '', $data['phone']);

        try {
            // Обновление основных данных пользователя
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $phone, // очищенный номер
            ]);

            // Обновление или создание адреса доставки
            DB::transaction(function () use ($user, $data) {
                $currentAddress = $user->deliveryAddress;

                if ($currentAddress) {
                    $hasOrders = $currentAddress->orders()->exists();

                    if ($hasOrders) {
                        // Если адрес уже использовался — создаём новый
                        $newAddress = DeliveryAddress::create([
                            'user_id' => $user->id,
                            'street' => $data['street'],
                            'city' => $data['city'],
                            'postal_code' => $data['postal_code'],
                        ]);
                        $user->deliveryAddress()->associate($newAddress); // Привязываем новый адрес
                    } else {
                        // Иначе обновляем существующий
                        $currentAddress->update([
                            'street' => $data['street'],
                            'city' => $data['city'],
                            'postal_code' => $data['postal_code'],
                        ]);
                    }
                } else {
                    // Если адреса не было — создаём новый
                    DeliveryAddress::create([
                        'user_id' => $user->id,
                        'street' => $data['street'],
                        'city' => $data['city'],
                        'postal_code' => $data['postal_code'],
                    ]);
                }
            });

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ошибка при обновлении информаии');
        }

        return redirect()->back()->with('success', 'Профиль обновлён');
    }
}
