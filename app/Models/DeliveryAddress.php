<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    // Массив атрибутов, которые могут быть массово присвоены
    protected $fillable = [
        'user_id',
        'street',
        'city',
        'postal_code'
    ];

    /**
     * Связь с пользователем
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь с заказами
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'delivery_address_id');
    }
}

