@extends('layouts.app')

@section('title', 'Pembayaran Reservasi - Studio LensArt')

@section('content')
<section class="customer-payment-page">

    <section class="customer-payment-hero">
        <div>
            <span class="customer-payment-kicker">Pembayaran QRIS</span>

            <h1>Pembayaran Reservasi</h1>

            <p>
                Scan QRIS Studio LensArt, lakukan pembayaran sesuai total harga,
                lalu upload bukti pembayaran untuk diverifikasi oleh owner.
            </p>
        </div>
    </section>

    @if (session('success'))
        <div class="customer-payment-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="customer-payment-alert error">
            <strong>Upload bukti pembayaran gagal.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="customer-payment-grid">
        <div class="customer-payment-card">
            <span class="customer-payment-kicker">Detail Reservasi</span>

            <h2>#{{ $reservasi->kode_booking }}</h2>

            <div class="customer-payment-detail-list">
                <div>
                    <span>Nama Pelanggan</span>
                    <strong>{{ $reservasi->nama_pelanggan }}</strong>
                </div>

                <div>
                    <span>Paket Foto</span>
                    <strong>{{ $reservasi->paket_foto }}</strong>
                </div>

                <div>
                    <span>Jadwal</span>
                    <strong>
                        {{ is_object($reservasi->tanggal_reservasi)
                            ? $reservasi->tanggal_reservasi->format('d M Y')
                            : date('d M Y', strtotime($reservasi->tanggal_reservasi)) }}
                        · {{ substr($reservasi->jam_reservasi, 0, 5) }}
                    </strong>
                </div>

                <div>
                    <span>Total Pembayaran</span>
                    <strong class="customer-payment-price">
                        Rp{{ number_format($reservasi->harga, 0, ',', '.') }}
                    </strong>
                </div>

                <div>
                    <span>Metode Pembayaran</span>
                    <strong>{{ $reservasi->metode_pembayaran ?? 'QRIS' }}</strong>
                </div>

                <div>
                    <span>Status Pembayaran</span>

                    <strong>
                        <span class="payment-status-badge payment-status-{{ strtolower(str_replace(' ', '-', $reservasi->status_pembayaran ?? 'Belum Bayar')) }}">
                            {{ $reservasi->status_pembayaran ?? 'Belum Bayar' }}
                        </span>
                    </strong>
                </div>
            </div>
        </div>

        <div class="customer-payment-card customer-qris-card">
            <span class="customer-payment-kicker">Scan QRIS</span>

            <h2>QRIS Studio LensArt</h2>

            <div class="customer-qris-box">
                <img src="{{ asset('images/qris-lensart.png') }}" alt="QRIS Studio LensArt">
            </div>

            <p>
                Scan QRIS di atas menggunakan aplikasi e-wallet atau mobile banking.
                Pastikan nominal pembayaran sesuai total harga reservasi.
            </p>
        </div>
    </section>

    <section class="customer-payment-upload-card">
        <div>
            <span class="customer-payment-kicker">Upload Bukti</span>
            <h2>Bukti Pembayaran</h2>
            <p>
                Setelah melakukan pembayaran, upload bukti transfer atau screenshot pembayaran QRIS.
            </p>
        </div>

        @if ($reservasi->bukti_pembayaran)
            <div class="customer-current-proof">
                <span>Bukti yang sudah diupload:</span>

                <a href="{{ asset('storage/' . $reservasi->bukti_pembayaran) }}" target="_blank">
                    Lihat Bukti Pembayaran
                </a>
            </div>
        @endif

        @if (($reservasi->status_pembayaran ?? 'Belum Bayar') !== 'Lunas')
            <form
                action="{{ route('customer.reservasi.upload-bukti', $reservasi->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="customer-payment-form"
            >
                @csrf

                <div class="customer-payment-group">
                    <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>

                    <input
                        type="file"
                        name="bukti_pembayaran"
                        id="bukti_pembayaran"
                        accept="image/png,image/jpeg,image/jpg"
                    >

                    <small>Format JPG, JPEG, atau PNG. Maksimal 2MB.</small>
                </div>

                <button type="submit" class="customer-payment-submit">
                    Kirim Bukti Pembayaran
                </button>
            </form>
        @else
            <div class="customer-payment-paid-note">
                Pembayaran kamu sudah lunas dan telah diverifikasi oleh owner.
            </div>
        @endif
    </section>
</section>
@endsection
