<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TeaType;

class TeaTypeSeeder extends Seeder
{
    /**
     * Сидер типа чая
     */
    public function run()
    {
        TeaType::create(['name' => 'Зеленый чай']);
        TeaType::create(['name' => 'Черный чай']);
        TeaType::create(['name' => 'Белый чай']);
        TeaType::create(['name' => 'Фруктовый чай']);
    }
}
