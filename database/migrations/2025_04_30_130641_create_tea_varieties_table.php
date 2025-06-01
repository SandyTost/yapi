<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TeaVariety;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tea_varieties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        TeaVariety::insert([
            ['name' => 'Ассам'],
            ['name' => 'Дарджилинг'],
            ['name' => 'Сенча'],
            ['name' => 'Лун Цзин'],
            ['name' => 'Пуэр'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tea_varieties');
    }
};
