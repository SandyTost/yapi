<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\FermentationDegree;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fermentation_degrees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        FermentationDegree::insert([
            ['name' => 'Неферментированный'],
            ['name' => 'Слабая ферментация'],
            ['name' => 'Средняя ферментация'],
            ['name' => 'Сильная ферментация'],
            ['name' => 'Полностью ферментированный'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fermentation_degrees');
    }
};
