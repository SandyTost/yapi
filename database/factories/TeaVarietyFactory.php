<?php

namespace Database\Factories;

use App\Models\TeaVariety;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeaVarietyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeaVariety::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Используем статический счетчик для обеспечения уникальности
        static $counter = 0;
        $counter++;

        $varieties = [
            'Да Хун Пао',
            'Тегуаньинь',
            'Дянь Хун',
            'Лун Цзин',
            'Би Ло Чунь',
            'Серебряные иглы',
            'Пуэр Шу',
            'Пуэр Шен',
            'Ассам',
            'Дарджилинг',
            'Цейлон',
            'Сенча',
            'Матча',
            'Эрл Грей',
            'Жасминовый'
        ];

        // Добавляем уникальный суффикс к имени
        $varietyName = $varieties[$counter % count($varieties)] . ' ' . $counter;

        return [
            'name' => $varietyName,
        ];
    }
}
