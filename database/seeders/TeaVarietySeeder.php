<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TeaVariety;

class TeaVarietySeeder extends Seeder
{
    /**
     * Сидер типа чая
     */
    public function run()
    {
        TeaVariety::create(['name' => 'Ассам']);
        TeaVariety::create(['name' => 'Дарджилинг']);
        TeaVariety::create(['name' => 'Сенча']);
        TeaVariety::create(['name' => 'Лун Цзин (Колодец Дракона)']);
        TeaVariety::create(['name' => 'Пуэр']);
    }
}
