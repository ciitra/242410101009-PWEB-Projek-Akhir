<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();

            $table->string('kode_booking')->unique();
            $table->string('nama_pelanggan');
            $table->string('email');
            $table->string('username_instagram');
            $table->string('no_hp');

            $table->integer('jumlah_orang');

            $table->enum('paket_foto', [
                'Paket Indie',
                'Paket LensArt',
                'Paket Kalcer',
                'Paket Custom'
            ]);

            $table->decimal('harga', 10, 2);

            $table->date('tanggal_reservasi');
            $table->time('jam_reservasi');

            $table->boolean('aktif')->default(true);
            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
