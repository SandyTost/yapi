<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Атрибуты для массового назначния
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone'
    ];

    /**
     * Атрибуты, которые стоит скрыть от сериализации
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Приведение атрибутов к необходимому виду
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Связь с адресом доставки
    public function deliveryAddress()
    {
        return $this->hasOne(DeliveryAddress::class);
    }

    // Связь с корзиной
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // Связь с заказами
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
