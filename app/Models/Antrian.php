<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nomor_antrian',
        'nama',
        'layanan_id',
        'loket_id',
        'status',
        'waktu_ambil',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'waktu_ambil' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the layanan associated with the antrian.
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * Get the loket associated with the antrian.
     */
    public function loket()
    {
        return $this->belongsTo(Loket::class);
    }
}
