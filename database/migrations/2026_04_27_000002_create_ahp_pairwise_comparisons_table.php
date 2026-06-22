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
        Schema::create('ahp_pairwise_comparisons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criteria_1_id'); // Kriteria pertama
            $table->unsignedBigInteger('criteria_2_id'); // Kriteria kedua
            $table->decimal('comparison_value', 5, 4); // Nilai perbandingan (1-9 atau 1/9)
            $table->decimal('consistency_ratio')->nullable(); // Rasio konsistensi
            $table->timestamps();

            $table->foreign('criteria_1_id')->references('id')->on('ahp_criteria')->onDelete('cascade');
            $table->foreign('criteria_2_id')->references('id')->on('ahp_criteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahp_pairwise_comparisons');
    }
};
