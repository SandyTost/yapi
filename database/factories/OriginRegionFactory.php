<?php

namespace Database\Factories;

use App\Models\OriginRegion;
use Illuminate\Database\Eloquent\Factories\Factory;

class OriginRegionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OriginRegion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 0;
        $counter++;

        $regions = [
            'Китай - Юньнань',
            'Китай - Фуцзянь',
            'Китай - Аньхой',
            'Индия - Дарджилинг',
            'Индия - Ассам',
            'Шри-Ланка (Цейлон)',
            'Япония',
            'Тайвань',
            'Кения',
            'Непал'
        ];

        // Добавляем уникальный суффикс к имени
        $regionName = $regions[$counter % count($regions)] . ' ' . $counter;

        return [
            'name' => $regionName,
        ];
    }
}
