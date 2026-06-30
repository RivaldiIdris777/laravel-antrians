<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_antrian'); 
            $table->string('nama')->nullable();                         
            $table->foreignId('layanan_id')
                  ->constrained('layanans')
                  ->onDelete('cascade');
                              
            $table->foreignId('loket_id')
                  ->nullable()
                  ->constrained('lokets')
                  ->onDelete('set null');                        
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai', 'batal'])->default('menunggu');
            
            $table->dateTime('waktu_ambil'); // Kapan nomor antrian dicetak
            $table->timestamps();                        
            $table->index(['waktu_ambil', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
