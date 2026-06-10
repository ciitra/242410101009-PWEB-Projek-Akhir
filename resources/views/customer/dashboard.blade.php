@extends('layouts.app')

@section('title', 'Dashboard Customer - Studio LensArt')

@section('content')
<section class="customer-dashboard-v2">

    {{-- HERO CUSTOMER --}}
    <section class="customer-hero-v3" id="beranda">
        <div class="customer-hero-v3-content">
            <div class="customer-hero-v3-text">
                <span class="customer-kicker-v3">Studio Foto Booking</span>

                <h1>
                    Halo, {{ auth()->user()->name }}
                    <br>
                    Siap Abadikan Momen Terbaikmu?
                </h1>

                <p>
                    Pilih paket foto favoritmu, tentukan jadwal pemotretan, dan buat reservasi
                    studio dengan mudah bersama Studio LensArt.
                </p>

                <div class="customer-hero-actions-v3">
                    <a href="{{ route('customer.reservasi.create') }}" class="customer-primary-button">
                        Reservasi Sekarang
                    </a>

                    <a href="#paket-customer" class="customer-secondary-button-v3">
                        Lihat Paket Foto
                    </a>
                </div>
            </div>

            <div class="customer-hero-v3-profile">
                <div class="customer-hero-logo-big">
                    <img src="{{ asset('images/logo-lensart.png') }}" alt="Logo Studio LensArt">
                </div>

                <div class="customer-mini-profile">
                    <div class="customer-mini-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div>
                        <h3>{{ auth()->user()->name }}</h3>
                        <p>{{ auth()->user()->email }}</p>
                        <span>Customer LensArt</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- QUICK OVERVIEW --}}
    <section class="customer-overview-grid">
        <article class="customer-overview-card">
            <div class="customer-overview-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M7 2v3M17 2v3M4 8h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                </svg>
            </div>

            <div>
                <span>Reservasi Online</span>
                <strong>Mudah Dibuat</strong>
                <p>Pilih paket dan jadwal sesuai kebutuhanmu.</p>
            </div>
        </article>

        <article class="customer-overview-card">
            <div class="customer-overview-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 7h16v13H4z"/>
                    <path d="M8 7a4 4 0 0 1 8 0"/>
                </svg>
            </div>

            <div>
                <span>Paket Foto</span>
                <strong>4 Pilihan</strong>
                <p>Indie, LensArt, Kalcer, dan Custom.</p>
            </div>
        </article>

        <article class="customer-overview-card">
            <div class="customer-overview-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </div>

            <div>
                <span>Jadwal Fleksibel</span>
                <strong>Pilih Sendiri</strong>
                <p>Tentukan tanggal dan jam pemotretan.</p>
            </div>
        </article>
    </section>

    {{-- SESSION VISIT COUNTER --}}
    <section class="customer-session-card-v2">
        <div class="customer-session-head">
            <div>
                <span class="customer-section-kicker">Aktivitas Kunjungan</span>
                <h2>Riwayat Kunjungan Dashboard</h2>
                <p>
                    Sistem mencatat jumlah kunjungan menggunakan session Laravel dan menampilkan waktu sesuai zona WIB.
                </p>
            </div>

            <form action="{{ route('customer.dashboard.reset-visit') }}" method="POST">
                @csrf

                <button type="submit" class="customer-reset-button">
                    Reset Hitungan
                </button>
            </form>
        </div>

        <div class="customer-session-grid">
            <div class="customer-session-item">
                <span>Jumlah Kunjungan</span>
                <strong>{{ $visitCount ?? 0 }} Kali</strong>
            </div>

            <div class="customer-session-item">
                <span>Kunjungan Pertama</span>
                <strong>{{ $firstVisit ?? '-' }}</strong>
            </div>

            <div class="customer-session-item">
                <span>Kunjungan Sebelumnya</span>
                <strong>{{ $previousVisit ?? 'Belum ada' }}</strong>
            </div>

            <div class="customer-session-item">
                <span>Kunjungan Saat Ini</span>
                <strong>{{ $currentVisit ?? '-' }}</strong>
            </div>
        </div>
    </section>

    {{-- PAKET FOTO CUSTOMER --}}
    <section class="customer-package-section-v2" id="paket-customer">
        <div class="customer-section-head-v2">
            <div>
                <span class="customer-section-kicker">Paket Foto</span>
                <h2>Pilih Paket Foto Favoritmu</h2>
            </div>
        </div>

        <div class="customer-package-grid-v2">
            <article class="customer-package-card-v2">
                <div class="customer-package-top">
                    <div class="customer-package-symbol">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 7h4l2-2h4l2 2h4v12H4z"/>
                            <path d="M12 17a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                        </svg>
                    </div>
                </div>

                <h3>Paket Indie</h3>
                <p>Durasi 10 menit sesi foto, 1 lembar print, dan softcopy file.</p>

                <div class="customer-package-price">Rp50.000</div>

                <a href="{{ route('customer.reservasi.create') }}" class="customer-package-button-v2">
                    Reservasi Paket
                </a>
            </article>

            <article class="customer-package-card-v2 package-popular-v2">
                <span class="customer-popular-badge">Favorit</span>

                <div class="customer-package-top">
                    <div class="customer-package-symbol">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.2 6.4 20.2 7.5 14 3 9.6l6.2-.9L12 3Z"/>
                        </svg>
                    </div>
                </div>

                <h3>Paket LensArt</h3>
                <p>Durasi 15 menit sesi foto, 2 lembar print, dan softcopy file.</p>

                <div class="customer-package-price">Rp80.000</div>

                <a href="{{ route('customer.reservasi.create') }}" class="customer-package-button-v2">
                    Reservasi Paket
                </a>
            </article>

            <article class="customer-package-card-v2">
                <div class="customer-package-top">
                    <div class="customer-package-symbol">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 6h16v12H4z"/>
                            <path d="M8 6V4h8v2"/>
                            <path d="M8 18v2h8v-2"/>
                        </svg>
                    </div>
                </div>

                <h3>Paket Kalcer</h3>
                <p>Durasi 20 menit sesi foto, 4 lembar print, dan softcopy file.</p>

                <div class="customer-package-price">Rp120.000</div>

                <a href="{{ route('customer.reservasi.create') }}" class="customer-package-button-v2">
                    Reservasi Paket
                </a>
            </article>

            <article class="customer-package-card-v2">
                <div class="customer-package-top">
                    <div class="customer-package-symbol">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 3v18M3 12h18"/>
                            <path d="M5 5l14 14M19 5 5 19"/>
                        </svg>
                    </div>
                </div>

                <h3>Paket Custom</h3>
                <p>Paket foto fleksibel yang dapat disesuaikan dengan kebutuhan pelanggan.</p>

                <div class="customer-package-price">Rp150.000</div>

                <a href="{{ route('customer.reservasi.create') }}" class="customer-package-button-v2">
                    Reservasi Paket
                </a>
            </article>
        </div>
    </section>

    {{-- KEUNGGULAN CUSTOMER --}}
    <section class="customer-feature-section-v2">
        <article class="customer-feature-card-v2">
            <span class="customer-feature-line"></span>
            <h3>Reservasi Mudah</h3>
            <p>Customer dapat memilih tanggal dan jam reservasi sesuai slot yang tersedia.</p>
        </article>

        <article class="customer-feature-card-v2">
            <span class="customer-feature-line"></span>
            <h3>Harga Transparan</h3>
            <p>Harga paket otomatis mengikuti pilihan paket foto tanpa perlu input manual.</p>
        </article>

        <article class="customer-feature-card-v2">
            <span class="customer-feature-line"></span>
            <h3>Studio Profesional</h3>
            <p>Studio LensArt menyediakan sesi foto indoor dengan hasil print dan softcopy.</p>
        </article>
    </section>

    {{-- CTA --}}
    <section class="customer-cta-v2">
        <div>
            <span class="customer-section-kicker">Reservasi</span>
            <h2>Sudah siap membuat reservasi?</h2>
            <p>
                Buat jadwal pemotretanmu sekarang dan lihat data reservasi melalui menu Reservasi.
            </p>
        </div>

        <a href="{{ route('customer.reservasi.create') }}" class="customer-primary-button">
            Buat Reservasi
        </a>
    </section>

    {{-- WEATHER BUTTON --}}
    <button type="button" class="lensart-weather-button" id="openWeatherCard">
        <span class="lensart-weather-button-icon">☁️</span>
        <span>Yuk cek cuaca hari ini!</span>
    </button>

    <div class="lensart-weather-overlay lensart-weather-hidden" id="weatherOverlay">
        <div class="lensart-weather-card">
            <button type="button" class="lensart-weather-close" id="closeWeatherCard">
                ×
            </button>

            <div class="lensart-weather-card-header">
                <span class="lensart-weather-label">LensArt Weather Check</span>
                <h2>Cuaca Studio Hari Ini</h2>
                <p>
                    Cek kondisi cuaca Jember sebelum menentukan jadwal reservasi foto.
                </p>
            </div>

            <div id="weatherLoading" class="lensart-weather-loading">
                Mengambil data cuaca...
            </div>

            <div id="weatherContent" class="lensart-weather-content lensart-weather-hidden">
                <div class="lensart-weather-main">
                    <div>
                        <span class="lensart-weather-city-label">Lokasi</span>
                        <h3 id="weatherCity">Jember</h3>
                    </div>

                    <div class="lensart-weather-temp">
                        <span id="weatherTemp">-</span>°C
                    </div>
                </div>

                <div class="lensart-weather-desc-box">
                    <span>Deskripsi Cuaca</span>
                    <p id="weatherDesc">-</p>
                </div>

                <div class="lensart-weather-note">
                    Informasi cuaca ini membantu customer mempertimbangkan waktu terbaik sebelum melakukan reservasi.
                </div>
            </div>

            <div id="weatherError" class="lensart-weather-error lensart-weather-hidden">
                Data cuaca belum berhasil dimuat. Silakan coba lagi nanti.
            </div>
        </div>
    </div>

</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openWeatherCard = document.getElementById('openWeatherCard');
        const closeWeatherCard = document.getElementById('closeWeatherCard');
        const weatherOverlay = document.getElementById('weatherOverlay');

        const weatherLoading = document.getElementById('weatherLoading');
        const weatherContent = document.getElementById('weatherContent');
        const weatherError = document.getElementById('weatherError');

        const weatherCity = document.getElementById('weatherCity');
        const weatherTemp = document.getElementById('weatherTemp');
        const weatherDesc = document.getElementById('weatherDesc');

        let weatherLoaded = false;

        async function loadWeatherData() {
            weatherLoading.classList.remove('lensart-weather-hidden');
            weatherContent.classList.add('lensart-weather-hidden');
            weatherError.classList.add('lensart-weather-hidden');

            try {
                const response = await fetch('https://wttr.in/Jember?format=j1');

                if (!response.ok) {
                    throw new Error('Gagal mengambil data cuaca.');
                }

                const data = await response.json();

                const city = data.nearest_area?.[0]?.areaName?.[0]?.value || 'Jember';
                const temperature = data.current_condition?.[0]?.temp_C || '-';
                const description = data.current_condition?.[0]?.weatherDesc?.[0]?.value || 'Deskripsi cuaca tidak tersedia';

                weatherCity.textContent = city;
                weatherTemp.textContent = temperature;
                weatherDesc.textContent = description;

                weatherLoading.classList.add('lensart-weather-hidden');
                weatherContent.classList.remove('lensart-weather-hidden');

                weatherLoaded = true;
            } catch (error) {
                weatherLoading.classList.add('lensart-weather-hidden');
                weatherError.classList.remove('lensart-weather-hidden');
            }
        }

        function openWeatherModal() {
            weatherOverlay.classList.remove('lensart-weather-hidden');

            if (!weatherLoaded) {
                loadWeatherData();
            }
        }

        function closeWeatherModal() {
            weatherOverlay.classList.add('lensart-weather-hidden');
        }

        openWeatherCard.addEventListener('click', openWeatherModal);
        closeWeatherCard.addEventListener('click', closeWeatherModal);

        weatherOverlay.addEventListener('click', function (event) {
            if (event.target === weatherOverlay) {
                closeWeatherModal();
            }
        });
    });
</script>
@endpush
