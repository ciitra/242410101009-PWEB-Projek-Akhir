@extends('layouts.app')

@section('title', 'Kontak Studio LensArt')

@section('content')

<header class="hero kontak-hero">
    <div class="hero-overlay hero-center-content">
        <img src="{{ asset('images/logo-lensart.png') }}" alt="Logo Studio LensArt" class="hero-logo-fixed">

        <h1>Kontak Studio LensArt</h1>

        <p>
            Punya pertanyaan tentang paket foto, jadwal reservasi, atau konsep pemotretan?
            Hubungi Studio LensArt melalui informasi kontak berikut.
        </p>
    </div>
</header>

<section class="about-section">
    <div class="about-card">
        <h2>Alamat Studio</h2>
        <p>
            Jl. Mawar No. 10, Jember
        </p>
        <p>
            Studio kami berada di lokasi yang mudah dijangkau dan nyaman untuk sesi foto bersama teman,
            keluarga, maupun pasangan.
        </p>
    </div>

    <div class="about-card">
        <h2>Email</h2>
        <p>
            studiolensart@gmail.com
        </p>
        <p>
            Kirim pertanyaan atau kebutuhan pemotretanmu melalui email, dan tim Studio LensArt akan membantu
            memberikan informasi yang kamu butuhkan.
        </p>
    </div>

    <div class="about-card">
        <h2>Telepon</h2>
        <p>
            0812-3456-7890
        </p>
        <p>
            Hubungi kami untuk mengecek jadwal kosong, pilihan paket, dan informasi reservasi lainnya.
        </p>
    </div>
</section>

<section class="contact-box">
    <h2>Jam Operasional</h2>

    <div class="contact-schedule">
        <div>
            <strong>Senin - Jumat</strong>
            <p>09.00 - 20.00</p>
        </div>

        <div>
            <strong>Sabtu - Minggu</strong>
            <p>10.00 - 21.00</p>
        </div>
    </div>

    <p class="contact-note">
        Untuk pengalaman terbaik, pelanggan disarankan melakukan reservasi terlebih dahulu sebelum datang ke studio.
    </p>

    <a href="{{ route('dashboard') }}#daftar-booking" class="about-button">Reservasi Sekarang</a>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const message = document.createElement('div');
        message.textContent = 'Halaman Kontak Studio LensArt berhasil dimuat.';
        message.style.position = 'fixed';
        message.style.bottom = '24px';
        message.style.right = '24px';
        message.style.background = '#fff7f2';
        message.style.color = '#5a3434';
        message.style.borderLeft = '5px solid #d48363';
        message.style.padding = '14px 18px';
        message.style.borderRadius = '12px';
        message.style.boxShadow = '0 8px 24px rgba(0, 0, 0, 0.14)';
        message.style.fontWeight = 'bold';
        message.style.zIndex = '3000';
        message.style.opacity = '0';
        message.style.transform = 'translateY(20px)';
        message.style.transition = '0.4s ease';

        document.body.appendChild(message);

        setTimeout(function () {
            message.style.opacity = '1';
            message.style.transform = 'translateY(0)';
        }, 200);

        setTimeout(function () {
            message.style.opacity = '0';
            message.style.transform = 'translateY(20px)';
        }, 4000);

        setTimeout(function () {
            message.remove();
        }, 4600);

        const contactButton = document.querySelector('.about-button');

        if (contactButton) {
            contactButton.addEventListener('click', function () {
                console.log('Tombol reservasi dari halaman kontak diklik.');
            });
        }

        console.log('Halaman Kontak Studio LensArt berhasil dimuat.');
    });
</script>
@endpush
