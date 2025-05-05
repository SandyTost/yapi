<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeaVariety extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    // Связь с моделью продуктов
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
