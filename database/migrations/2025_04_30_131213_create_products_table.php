<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description');
            $table->string('image', 100);
            $table->integer('price');
            $table->foreignId('tea_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('origin_region_id')->constrained()->onDelete('cascade');
            $table->foreignId('tea_variety_id')->constrained()->onDelete('cascade');
            $table->foreignId('fermentation_degree_id')->constrained()->onDelete('cascade');
            $table->foreignId('storage_condition_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
