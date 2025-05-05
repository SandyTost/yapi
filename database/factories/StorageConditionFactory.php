<?php

namespace Database\Factories;

use App\Models\StorageCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class StorageConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StorageCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 0;
        $counter++;

        $conditions = [
            'Хранить в сухом месте',
            'Хранить в герметичной упаковке',
            'Хранить вдали от прямых солнечных лучей',
            'Хранить при комнатной температуре',
            'Хранить в холодильнике после вскрытия'
        ];

        // Добавляем уникальный суффикс к имени
        $conditionName = $conditions[$counter % count($conditions)] . ' ' . $counter;

        return [
            'description' => $conditionName,
        ];
    }
}
