<?php

namespace Database\Factories;

use App\Models\FermentationDegree;
use Illuminate\Database\Eloquent\Factories\Factory;

class FermentationDegreeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FermentationDegree::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 0;
        $counter++;

        $degrees = [
            'Неферментированный (0-10%)',
            'Слабоферментированный (10-30%)',
            'Среднеферментированный (30-60%)',
            'Сильноферментированный (60-85%)',
            'Полностью ферментированный (85-100%)',
            'Постферментированный'
        ];

        // Добавляем уникальный суффикс к имени
        $degreeName = $degrees[$counter % count($degrees)] . ' ' . $counter;

        return [
            'name' => $degreeName,
        ];
    }
}
