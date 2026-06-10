<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan_reservasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reservasi_id')
                ->constrained('reservasis')
                ->cascadeOnDelete();

            $table->foreignId('layanan_tambahan_id')
                ->constrained('layanan_tambahans')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['reservasi_id', 'layanan_tambahan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_reservasi');
    }
};


