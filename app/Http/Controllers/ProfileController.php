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
use Log;

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
    /**
     * Обновление информации профиля
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $phone = preg_replace('/\D/', '', $data['phone']);

        try {
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $phone,
            ]);

            DB::transaction(function () use ($user, $data) {
                // Получаем последний адрес пользователя
                $currentAddress = $user->deliveryAddresses()->latest()->first();

                if ($currentAddress) {
                    $hasOrders = $currentAddress->orders()->exists();

                    if ($hasOrders) {
                        // Адрес использовался — создаём новый
                        $newAddress = DeliveryAddress::create([
                            'user_id' => $user->id,
                            'street' => $data['street'],
                            'city' => $data['city'],
                            'postal_code' => $data['postal_code'],
                        ]);

                        // Обновляем связь в модели User, чтобы она указывала на новый адрес
                        $user->refresh();
                    } else {
                        // Иначе обновляем существующий
                        $currentAddress->update([
                            'street' => $data['street'],
                            'city' => $data['city'],
                            'postal_code' => $data['postal_code'],
                        ]);
                    }
                } else {
                    // Нет адреса — создаём
                    DeliveryAddress::create([
                        'user_id' => $user->id,
                        'street' => $data['street'],
                        'city' => $data['city'],
                        'postal_code' => $data['postal_code'],
                    ]);
                }
            });

        } catch (\Exception $e) {
            \Log::error('Ошибка при обновлении профиля: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при обновлении информации');
        }

        return redirect()->back()->with('success', 'Профиль обновлён');
    }
}
