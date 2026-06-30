<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nama_layanan',
        'kode_layanan',
        'prefix_antrian',
        'suara_panggilan',
        'deskripsi',
        'status_aktif',
    ];    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
