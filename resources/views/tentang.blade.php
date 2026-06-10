@extends('layouts.app')

@section('title', 'Tentang Studio LensArt')

@section('content')

<header class="hero tentang-hero">
    <div class="hero-overlay hero-center-content">
        <img src="{{ asset('images/logo-lensart.png') }}" alt="Logo Studio LensArt" class="hero-logo-fixed">

        <h1>Tentang Studio LensArt</h1>

        <p>
            Studio LensArt adalah studio foto kreatif yang membantu pelanggan mengabadikan
            momen terbaik melalui hasil foto yang estetik, nyaman, dan berkesan.
        </p>
    </div>
</header>

<section class="about-section">
    <div class="about-card">
        <h2>Siapa Kami?</h2>
        <p>
            Studio LensArt menyediakan layanan pemotretan untuk berbagai kebutuhan, seperti foto personal,
            couple, sahabat, keluarga, hingga kebutuhan konten media sosial. Dengan suasana studio yang
            nyaman, pelanggan dapat menikmati pengalaman foto yang lebih santai dan menyenangkan.
        </p>
    </div>

    <div class="about-card">
        <h2>Konsep Studio</h2>
        <p>
            Studio LensArt mengusung konsep foto modern, simpel, dan kekinian. Setiap paket foto dirancang
            agar pelanggan dapat memilih layanan sesuai kebutuhan, mulai dari sesi singkat sampai sesi foto
            yang lebih fleksibel.
        </p>
    </div>

    <div class="about-card">
        <h2>Keunggulan LensArt</h2>
        <ul>
            <li>Pilihan paket foto yang praktis dan terjangkau</li>
            <li>Proses reservasi yang mudah digunakan</li>
            <li>Hasil foto cocok untuk kenangan dan media sosial</li>
            <li>Suasana studio nyaman untuk berbagai pelanggan</li>
            <li>Pelayanan ramah dan proses booking sederhana</li>
        </ul>
    </div>
</section>

<section class="about-highlight">
    <h2>Abadikan Momenmu Bersama Studio LensArt</h2>
    <p>
        Setiap momen punya cerita. Di Studio LensArt, kami membantu menangkap cerita itu
        melalui foto yang indah, personal, dan layak dikenang.
    </p>
    <a href="{{ route('dashboard') }}#daftar-booking" class="about-button">Booking Sekarang</a>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const message = document.createElement('div');
        message.textContent = 'Halaman Tentang Studio LensArt berhasil dimuat.';
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

        const aboutCards = document.querySelectorAll('.about-card');

        aboutCards.forEach(function (card) {
            card.addEventListener('mouseenter', function () {
                card.style.transform = 'translateY(-4px)';
                card.style.transition = '0.3s ease';
            });

            card.addEventListener('mouseleave', function () {
                card.style.transform = 'translateY(0)';
            });
        });

        console.log('Halaman Tentang Studio LensArt berhasil dimuat.');
    });
</script>
@endpush
