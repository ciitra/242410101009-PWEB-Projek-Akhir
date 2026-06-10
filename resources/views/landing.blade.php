@extends('layouts.app')

@section('title', 'Studio LensArt - Beranda')

@section('content')

<section class="hero" id="beranda">
    <div class="hero-overlay hero-center-content">
        <img src="{{ asset('images/logo-lensart.png') }}"
             alt="Logo Studio LensArt"
             class="hero-logo hero-logo-fixed">

        <h1>Selamat datang di Studio LensArt</h1>

        <p>
            Website ini menyediakan informasi paket foto serta layanan reservasi
            pelanggan di Studio LensArt.
        </p>
    </div>
</section>

<main class="public-home-container">

    {{-- PAKET FOTO --}}
    <section class="public-home-section" id="paket-foto">
        <div class="section-header">
            <h2 class="section-title">Paket Foto</h2>
        </div>

        <div class="card-grid">
            @foreach ($paketFotos as $paket)
                <div class="card">
                    <h3>{{ $paket['nama'] }}</h3>
                    <p>{{ $paket['deskripsi'] }}</p>
                    <div class="card-price">{{ $paket['harga'] }}</div>

                    <br>

                    <a href="{{ route('login') }}" class="btn-create">
                        Reservasi Paket
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- GALERI FOTO --}}
    <section class="public-home-section">
        <div class="section-header gallery-header">
            <div>
                <h2 class="section-title">Hasil Foto Studio</h2>
            </div>

            <div class="gallery-control">
                <button type="button" class="gallery-btn" id="galleryPrev">‹</button>
                <button type="button" class="gallery-btn" id="galleryNext">›</button>
            </div>
        </div>

        <div class="gallery-scroll-wrapper" id="galleryScroll">
            <div class="gallery-slide-card">
                <img src="{{ asset('images/gallery/foto-1.jpg') }}" alt="Contoh foto studio 1">
                <div>
                    <h3>Portrait Studio</h3>
                    <p>Konsep foto personal dengan pencahayaan studio.</p>
                </div>
            </div>

            <div class="gallery-slide-card">
                <img src="{{ asset('images/gallery/foto-2.jpg') }}" alt="Contoh foto studio 2">
                <div>
                    <h3>Couple Photo</h3>
                    <p>Foto bersama pasangan dengan konsep simpel dan elegan.</p>
                </div>
            </div>

            <div class="gallery-slide-card">
                <img src="{{ asset('images/gallery/foto-3.jpg') }}" alt="Contoh foto studio 3">
                <div>
                    <h3>Group Photo</h3>
                    <p>Foto bersama teman, keluarga, atau komunitas.</p>
                </div>
            </div>

            <div class="gallery-slide-card">
                <img src="{{ asset('images/gallery/foto-4.jpg') }}" alt="Contoh foto studio 4">
                <div>
                    <h3>Creative Concept</h3>
                    <p>Konsep foto kreatif sesuai kebutuhan pelanggan.</p>
                </div>
            </div>

            <div class="gallery-slide-card">
                <img src="{{ asset('images/gallery/foto-5.jpg') }}" alt="Contoh foto studio 5">
                <div>
                    <h3>Graduation Photo</h3>
                    <p>Foto wisuda atau pencapaian spesial dengan konsep rapi.</p>
                </div>
            </div>

            <div class="gallery-slide-card">
                <img src="{{ asset('images/gallery/foto-6.jpg') }}" alt="Contoh foto studio 6">
                <div>
                    <h3>Family Photo</h3>
                    <p>Foto keluarga dengan suasana hangat dan elegan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA RESERVASI --}}
    <section class="about-highlight public-home-cta">
        <h2>Ingin Melakukan Reservasi?</h2>
        <p>
            Silakan login terlebih dahulu untuk memilih jadwal dan membuat
            reservasi studio foto secara online.
        </p>

        <a href="{{ route('login') }}" class="about-button">
            Login untuk Reservasi
        </a>
    </section>

</main>

<script>
    const galleryScroll = document.getElementById('galleryScroll');
    const galleryPrev = document.getElementById('galleryPrev');
    const galleryNext = document.getElementById('galleryNext');

    if (galleryScroll && galleryPrev && galleryNext) {
        galleryPrev.addEventListener('click', function () {
            galleryScroll.scrollBy({
                left: -340,
                behavior: 'smooth'
            });
        });

        galleryNext.addEventListener('click', function () {
            galleryScroll.scrollBy({
                left: 340,
                behavior: 'smooth'
            });
        });
    }
</script>

@endsection
