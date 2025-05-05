<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FermentationDegree;

class FermentationDegreeSeeder extends Seeder
{
    /**
     * Сидер степени ферментации
     */
    public function run()
    {
        FermentationDegree::create(['name' => 'Неферментированный']);
        FermentationDegree::create(['name' => 'Слабая ферментация']);
        FermentationDegree::create(['name' => 'Средняя ферментация']);
        FermentationDegree::create(['name' => 'Сильная ферментация']);
        FermentationDegree::create(['name' => 'Полностью ферментированный']);
    }
}
