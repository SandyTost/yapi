<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'tea_type_id',
        'origin_region_id',
        'tea_variety_id',
        'fermentation_degree_id',
        'storage_condition_id'
    ];

    // Связь с моделью Тип чая
    public function teaType()
    {
        return $this->belongsTo(TeaType::class);
    }

    // Связь с моделью Регион происхождения
    public function originRegion()
    {
        return $this->belongsTo(OriginRegion::class);
    }

    // Связь с моделью Сорт чая
    public function teaVariety()
    {
        return $this->belongsTo(TeaVariety::class);
    }

    // Связь с моделью Степень ферментации
    public function fermentationDegree()
    {
        return $this->belongsTo(FermentationDegree::class);
    }

    // Связь с моделью как хранить
    public function storageCondition()
    {
        return $this->belongsTo(StorageCondition::class);
    }
}
