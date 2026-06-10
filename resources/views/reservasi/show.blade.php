@extends('layouts.app')

@section('title', 'Detail Reservasi - Studio LensArt')

@section('content')
<section class="owner-detail-page">

    {{-- HERO --}}
    <section class="owner-detail-hero">
        <div>
            <span class="owner-detail-kicker">Detail Reservasi</span>

            <h1>Detail Booking Studio LensArt</h1>

            <p>
                Lihat informasi lengkap data pelanggan, jadwal pemotretan,
                paket foto, status pembayaran, dan bukti pembayaran customer.
            </p>
        </div>

        <a href="{{ route('reservasi.index') }}" class="owner-detail-back">
            Kembali ke Daftar
        </a>
    </section>

    @php
        $statusPembayaran = $reservasi->status_pembayaran ?? 'Belum Bayar';

        $paymentClass = match ($statusPembayaran) {
            'Menunggu Verifikasi' => 'owner-payment-waiting',
            'Lunas' => 'owner-payment-paid',
            'Ditolak' => 'owner-payment-rejected',
            default => 'owner-payment-unpaid',
        };
    @endphp

    {{-- MAIN DETAIL --}}
    <section class="owner-detail-main-card">
        <div class="owner-detail-main-head">
            <div>
                <span>Kode Booking</span>
                <h2>#{{ $reservasi->kode_booking }}</h2>
                <p>{{ $reservasi->nama_pelanggan }}</p>
            </div>

            <div class="owner-detail-status-wrap">
                <span class="owner-payment-badge {{ $paymentClass }}">
                    {{ $statusPembayaran }}
                </span>
            </div>
        </div>

        <div class="owner-detail-grid">

            {{-- DATA PELANGGAN --}}
            <section class="owner-detail-block">
                <div class="owner-detail-block-head">
                    <div class="owner-detail-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                            <path d="M4 21a8 8 0 0 1 16 0"/>
                        </svg>
                    </div>

                    <div>
                        <span class="owner-detail-kicker">Data Pelanggan</span>
                        <h3>Identitas Customer</h3>
                    </div>
                </div>

                <div class="owner-detail-list">
                    <div class="owner-detail-item">
                        <span>Nama Pelanggan</span>
                        <strong>{{ $reservasi->nama_pelanggan }}</strong>
                    </div>

                    <div class="owner-detail-item">
                        <span>Email</span>
                        <strong>{{ $reservasi->email }}</strong>
                    </div>

                    <div class="owner-detail-item">
                        <span>Username Instagram</span>
                        <strong>{{ $reservasi->username_instagram }}</strong>
                    </div>

                    <div class="owner-detail-item">
                        <span>No. HP</span>
                        <strong>{{ $reservasi->no_hp }}</strong>
                    </div>
                </div>
            </section>

            {{-- INFORMASI RESERVASI --}}
            <section class="owner-detail-block">
                <div class="owner-detail-block-head">
                    <div class="owner-detail-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 7h16v13H4z"/>
                            <path d="M8 7a4 4 0 0 1 8 0"/>
                        </svg>
                    </div>

                    <div>
                        <span class="owner-detail-kicker">Informasi Reservasi</span>
                        <h3>Paket & Jadwal</h3>
                    </div>
                </div>

                <div class="owner-detail-list">
                    <div class="owner-detail-item">
                        <span>Paket Foto</span>
                        <strong>{{ $reservasi->paket_foto }}</strong>
                    </div>

                    <div class="owner-detail-item">
                        <span>Harga</span>
                        <strong class="owner-detail-price">
                            Rp{{ number_format($reservasi->harga, 0, ',', '.') }}
                        </strong>
                    </div>

                    <div class="owner-detail-item">
                        <span>Jumlah Orang</span>
                        <strong>{{ $reservasi->jumlah_orang }} Orang</strong>
                    </div>

                    <div class="owner-detail-item">
                        <span>Tanggal Reservasi</span>
                        <strong>
                            {{ is_object($reservasi->tanggal_reservasi)
                                ? $reservasi->tanggal_reservasi->format('d M Y')
                                : date('d M Y', strtotime($reservasi->tanggal_reservasi)) }}
                        </strong>
                    </div>

                    <div class="owner-detail-item">
                        <span>Jam Reservasi</span>
                        <strong>{{ substr($reservasi->jam_reservasi, 0, 5) }}</strong>
                    </div>
                </div>
            </section>
        </div>

        {{-- PEMBAYARAN --}}
        <section class="owner-payment-detail-card">
            <div class="owner-detail-block-head">
                <div class="owner-detail-icon owner-payment-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3 6h18v12H3z"/>
                        <path d="M7 10h.01M11 10h6M7 14h4"/>
                    </svg>
                </div>

                <div>
                    <span class="owner-detail-kicker">Pembayaran</span>
                    <h3>Informasi Pembayaran</h3>
                    <p>
                        Status pembayaran customer dan bukti pembayaran yang sudah diupload.
                    </p>
                </div>
            </div>

            <div class="owner-payment-grid">
                <div class="owner-detail-item">
                    <span>Metode Pembayaran</span>
                    <strong>{{ $reservasi->metode_pembayaran ?? 'QRIS' }}</strong>
                </div>

                <div class="owner-detail-item">
                    <span>Status Pembayaran</span>
                    <strong>
                        <span class="owner-payment-badge {{ $paymentClass }}">
                            {{ $statusPembayaran }}
                        </span>
                    </strong>
                </div>

                <div class="owner-detail-item">
                    <span>Total Pembayaran</span>
                    <strong class="owner-detail-price">
                        Rp{{ number_format($reservasi->harga, 0, ',', '.') }}
                    </strong>
                </div>
            </div>

            @if ($reservasi->bukti_pembayaran)
                <div class="owner-proof-box">
                    <div>
                        <span>Bukti Pembayaran</span>
                        <strong>Customer sudah mengupload bukti pembayaran.</strong>
                        <p>Klik tombol di bawah untuk melihat bukti pembayaran di tab baru.</p>
                    </div>

                    <a
                        href="{{ asset('storage/' . $reservasi->bukti_pembayaran) }}"
                        target="_blank"
                        class="owner-proof-button"
                    >
                        Lihat Bukti Pembayaran
                    </a>
                </div>
            @else
                @if (($reservasi->metode_pembayaran ?? 'QRIS') === 'Manual Owner')
                    <div class="owner-proof-empty">
                        Reservasi ini dibuat oleh owner dan pembayaran sudah ditandai lunas secara manual.
                    </div>
                @else
                    <div class="owner-proof-empty">
                        Customer belum mengupload bukti pembayaran.
                    </div>
                @endif
            @endif

            @if ($reservasi->bukti_pembayaran)
                <div class="owner-payment-verification-box">
                    <div>
                        <span class="owner-detail-kicker">Verifikasi Pembayaran</span>
                        <h3>Konfirmasi Status Pembayaran</h3>
                        <p>
                            Periksa bukti pembayaran customer terlebih dahulu, lalu tandai pembayaran
                            sebagai lunas atau tolak jika bukti tidak sesuai.
                        </p>
                    </div>

                    <div class="owner-payment-verification-actions">
                        @if ($statusPembayaran !== 'Lunas')
                            <form
                                action="{{ route('reservasi.pembayaran.lunas', $reservasi->id) }}"
                                method="POST"
                                onsubmit="return confirm('Tandai pembayaran ini sebagai lunas?')"
                            >
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="owner-payment-approve-button">
                                    Tandai Lunas
                                </button>
                            </form>
                        @endif

                        @if ($statusPembayaran !== 'Ditolak')
                            <form
                                action="{{ route('reservasi.pembayaran.tolak', $reservasi->id) }}"
                                method="POST"
                                onsubmit="return confirm('Tolak pembayaran ini?')"
                            >
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="owner-payment-reject-button">
                                    Tolak Pembayaran
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        </section>

        {{-- ACTION --}}
        <div class="owner-detail-actions">
            <a href="{{ route('reservasi.index') }}" class="owner-detail-cancel">
                Kembali
            </a>

            <a href="{{ route('reservasi.edit', $reservasi->id) }}" class="owner-detail-edit">
                Edit Reservasi
            </a>
        </div>
    </section>
</section>
@endsection
