<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananTambahan extends Model
{
    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'harga',
        'aktif',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function reservasis()
    {
        return $this->belongsToMany(
            Reservasi::class,
            'layanan_reservasi',
            'layanan_tambahan_id',
            'reservasi_id'
        );
    }
}


