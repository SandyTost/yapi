<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delivery_address_id',
        'status',
        'payment_method',
        'total_amount',
    ];

    // Связь с товарами в заказе
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с адресом доставки
    public function deliveryAddress()
    {
        return $this->belongsTo(DeliveryAddress::class);
    }

    public function getStatusTranslatedAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'В обработке'; // Статус в обработке
            case 'completed':
                return 'Выполнен'; // Статус выполнен
            default:
                return 'Неизвестный статус';
        }
    }
}
