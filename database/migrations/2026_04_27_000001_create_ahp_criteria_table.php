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
        Schema::create('ahp_criteria', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Dampak", "Urgensi", "Kompleksitas"
            $table->text('description')->nullable();
            $table->decimal('weight', 5, 4)->default(0); // Bobot kriteria hasil normalisasi
            $table->integer('order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahp_criteria');
    }
};
