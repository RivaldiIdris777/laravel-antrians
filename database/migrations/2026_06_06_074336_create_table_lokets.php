<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_loket');
            $table->string('kode_loket')->unique();                        
            $table->foreignId('layanan_id')
                  ->constrained('layanans')
                  ->onDelete('cascade');                              
            $table->enum('status', ['buka', 'tutup', 'istirahat'])->default('tutup');            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokets');
    }
};
