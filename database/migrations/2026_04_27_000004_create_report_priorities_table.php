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
        Schema::create('report_priorities', function (Blueprint $table) {
            $table->id();
            $table->string('report_id')->unique(); // Track ID laporan
            $table->decimal('ahp_score', 5, 4)->default(0); // Skor AHP akhir (0-1)
            $table->integer('priority_rank')->nullable(); // Ranking urgensi (1, 2, 3, dll)
            $table->timestamp('last_calculated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_priorities');
    }
};
