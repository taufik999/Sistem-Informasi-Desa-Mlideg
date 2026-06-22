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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('track_id')->unique();
            $table->string('tanggal');
            $table->string('nama');
            $table->string('hp')->nullable();
            $table->string('dusun')->nullable();
            $table->string('kategori')->nullable();
            $table->string('subjek')->nullable();
            $table->text('pesan')->nullable();
            $table->string('foto')->nullable();
            $table->string('status')->default('Menunggu Validasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
