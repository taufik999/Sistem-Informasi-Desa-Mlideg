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
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('nkk', 16);
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->text('alamat');
            $table->string('dusun');
            $table->string('kewarganegaraan')->default('WNI');
            $table->string('agama');
            $table->string('status_kawin');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->enum('status', ['Aktif', 'Pindah', 'Meninggal'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
