<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StorageCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    // Связь с моделью товара
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
