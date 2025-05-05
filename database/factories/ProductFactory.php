<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\TeaType;
use App\Models\OriginRegion;
use App\Models\TeaVariety;
use App\Models\FermentationDegree;
use App\Models\StorageCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(3),
            'image' => 'default-tea-' . $this->faker->numberBetween(1, 5) . '.jpg',
            'price' => $this->faker->numberBetween(100, 2000),
            'tea_type_id' => TeaType::factory(),
            'origin_region_id' => OriginRegion::factory(),
            'tea_variety_id' => TeaVariety::factory(),
            'fermentation_degree_id' => FermentationDegree::factory(),
            'storage_condition_id' => StorageCondition::factory(),
        ];
    }
}
