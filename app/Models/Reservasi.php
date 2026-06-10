<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $fillable = [
        'user_id',
        'kode_booking',
        'nama_pelanggan',
        'email',
        'username_instagram',
        'no_hp',
        'jumlah_orang',
        'paket_foto',
        'harga',
        'metode_pembayaran',
        'status_pembayaran',
        'bukti_pembayaran',
        'tanggal_reservasi',
        'jam_reservasi',
        'aktif',
        'foto',
    ];

    protected $casts = [
        'jumlah_orang' => 'integer',
        'harga' => 'decimal:2',
        'tanggal_reservasi' => 'date',
        'aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function layananTambahans()
    {
        return $this->belongsToMany(
            LayananTambahan::class,
            'layanan_reservasi',
            'reservasi_id',
            'layanan_tambahan_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

