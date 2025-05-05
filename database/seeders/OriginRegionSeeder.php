<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OriginRegion;

class OriginRegionSeeder extends Seeder
{
    /**
     * Сидер для регионов
     */
    public function run()
    {
        OriginRegion::create(['name' => 'Китай']);
        OriginRegion::create(['name' => 'Индия']);
        OriginRegion::create(['name' => 'Япония']);
        OriginRegion::create(['name' => 'Тайвань']);
    }
}
