<?php

namespace Database\Factories;

use App\Models\TeaType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeaTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeaType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word . ' ' . $this->faker->word . ' Tea',
        ];
    }
}
