<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->string('kode_layanan')->unique();
            $table->string('prefix_antrian', 5);
            $table->string('suara_panggilan')->nullable();
            $table->text('deskripsi')->nullable();                        
            $table->enum('status_aktif', ['aktif', 'tidak_aktif', 'pending', 'ditunda'])->default('aktif');            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};