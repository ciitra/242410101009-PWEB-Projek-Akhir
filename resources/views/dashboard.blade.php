@extends('layouts.app')

@section('title', 'Studio LensArt - Dashboard Owner')

@section('content')
<main class="owner-dashboard-v2">

    {{-- HERO / WELCOME --}}
    <section class="owner-hero-v2" id="beranda">
        <div class="owner-hero-left">
            <span class="owner-hero-label">Dashboard Owner</span>

            <h1>Kelola Reservasi Studio LensArt dengan Lebih Rapi</h1>

            <p>
                Pantau data reservasi pelanggan, lihat ringkasan performa studio,
                dan cek paket foto yang paling diminati dalam satu tampilan yang clean dan modern.
            </p>

            <div class="owner-hero-meta">
                <div class="owner-meta-box">
                    <span>Total Paket</span>
                    <strong>{{ count($paketFotos) }}</strong>
                </div>

                <div class="owner-meta-box">
                    <span>Total Reservasi</span>
                    <strong>{{ $totalReservasi }}</strong>
                </div>

                <div class="owner-meta-box">
                    <span>Paket Terpopuler</span>
                    <strong>{{ $paketFavorit }}</strong>
                </div>
            </div>
        </div>

        <div class="owner-hero-right">
            <div class="owner-overview-card">
                <div class="owner-overview-logo-wrap">
                    <img src="{{ asset('images/logo-lensart.png') }}"
                        alt="Logo Studio LensArt"
                        class="owner-overview-logo">
                </div>

                <span class="overview-badge">Overview Studio</span>

                <h3>Studio LensArt</h3>

                <div class="owner-overview-list">
                    <div class="overview-item">
                        <span class="overview-dot dot-primary"></span>
                        <span>{{ $reservasiHariIni }} reservasi hari ini</span>
                    </div>

                    <div class="overview-item">
                        <span class="overview-dot dot-secondary"></span>
                        <span>{{ $slotTersedia }} slot tersedia hari ini</span>
                    </div>

                    <div class="overview-item">
                        <span class="overview-dot dot-soft"></span>
                        <span>Status studio: {{ $statusStudio }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{-- STATISTICS --}}
<section class="owner-summary-grid">
    @forelse ($statCards as $stat)
        <article class="owner-summary-card {{ $stat['warna'] }}">
            <div class="owner-summary-top">
                <div class="owner-summary-icon icon-{{ $stat['ikon'] }}">
                    @switch($stat['ikon'])
                        @case('calendar')
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M7 2v3M17 2v3M4 8h16M6 5h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                            </svg>
                            @break

                        @case('clock')
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>
                            @break

                        @case('income')
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4 7h16v10H4z"/>
                                <path d="M8 11h.01M16 13h.01M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            </svg>
                            @break

                        @default
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M4 7h16v13H4z"/>
                                <path d="M8 7a4 4 0 0 1 8 0"/>
                            </svg>
                    @endswitch
                </div>

                <span class="owner-summary-accent"></span>
            </div>

            <span class="owner-summary-label">{{ $stat['judul'] }}</span>
            <h3>{{ $stat['nilai'] }}</h3>
            <p>{{ $stat['keterangan'] }}</p>
        </article>
    @empty
        <p class="empty-state">Data statistik belum tersedia.</p>
    @endforelse
</section>

    {{-- MAIN GRID --}}
    <section class="owner-main-grid">

        {{-- LEFT CONTENT --}}
        <div class="owner-main-left">

            {{-- RESERVASI TERBARU --}}
            <section class="owner-panel-v2" id="statistik">
                <div class="owner-section-head">
                    <div>
                        <span class="section-kicker">Ringkasan</span>
                        <h2>Reservasi Terbaru</h2>
                    </div>

                    <a href="{{ route('reservasi.index') }}" class="owner-link-button">
                        Lihat Semua
                    </a>
                </div>

                <div class="owner-table-wrapper">
                    <table class="owner-modern-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Paket</th>
                                <th>Jadwal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($reservasiDummies as $reservasi)
                                <tr>
                                    <td>
                                        <strong>#{{ $reservasi['kode'] ?? '-' }}</strong>
                                    </td>

                                    <td>
                                        <div class="owner-customer-info">
                                            <strong>{{ $reservasi['nama'] ?? '-' }}</strong>
                                            <span>{{ $reservasi['email'] ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="owner-package-chip">
                                            {{ $reservasi['paket'] ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="owner-schedule-info">
                                            <strong>
                                                @if (!empty($reservasi['tanggal']))
                                                    {{ \Carbon\Carbon::parse($reservasi['tanggal'])->format('d M Y') }}
                                                @else
                                                    -
                                                @endif
                                            </strong>

                                            <span>
                                                {{ !empty($reservasi['jam']) ? substr($reservasi['jam'], 0, 5) : '-' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        {{ $reservasi['jumlah_orang'] ?? 0 }} Orang
                                    </td>
                                    <td>
                                        @php
                                            $tanggalReservasi = !empty($reservasi['tanggal'])
                                                ? \Carbon\Carbon::parse($reservasi['tanggal'])
                                                : null;

                                            if (!$tanggalReservasi) {
                                                $statusReservasi = 'Belum Terjadwal';
                                                $statusBadgeClass = 'badge-muted';
                                            } elseif ($tanggalReservasi->isToday()) {
                                                $statusReservasi = 'Hari Ini';
                                                $statusBadgeClass = 'badge-today';
                                            } elseif ($tanggalReservasi->isFuture()) {
                                                $statusReservasi = 'Terjadwal';
                                                $statusBadgeClass = 'badge-scheduled';
                                            } else {
                                                $statusReservasi = 'Selesai';
                                                $statusBadgeClass = 'badge-done';
                                            }
                                        @endphp

                                        <span class="owner-status-badge {{ $statusBadgeClass }}">
                                            {{ $statusReservasi }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        Data reservasi belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- PAKET FOTO --}}
            <section id="paket" class="owner-panel-v2">
                <div class="owner-section-head">
                    <div>
                        <span class="section-kicker">Layanan</span>
                        <h2>Paket Foto Studio LensArt</h2>
                    </div>
                </div>

                <div class="owner-package-grid-v2">
                    @forelse ($paketFotos as $paket)
                        <article class="owner-package-card-v2">
                            <div class="owner-package-header">
                                <h3>{{ $paket['nama'] }}</h3>
                                <span class="package-mini-line"></span>
                            </div>

                            <p>{{ $paket['deskripsi'] }}</p>

                            <div class="owner-package-footer">
                                <strong>{{ $paket['harga'] }}</strong>
                            </div>
                        </article>
                    @empty
                        <p class="empty-state">Data paket foto belum tersedia.</p>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- RIGHT CONTENT --}}
        <aside class="owner-main-right">

            {{-- STATISTIK SINGKAT --}}
            <section class="owner-panel-v2 owner-side-panel">
                <div class="owner-section-head small">
                    <div>
                        <span class="section-kicker">Insight</span>
                        <h2>Statistik Singkat</h2>
                    </div>
                </div>

                <div class="owner-insight-list-v2">
                    @forelse ($insightStudio as $insight)
                        <div class="owner-insight-item-v2">
                            <span>{{ $insight['label'] }}</span>

                            @if ($insight['label'] === 'Status Studio Hari Ini')
                                <strong class="{{ $statusClass }}">
                                    {{ $insight['nilai'] }}
                                </strong>
                            @else
                                <strong>{{ $insight['nilai'] }}</strong>
                            @endif
                        </div>
                    @empty
                        <p class="empty-state">Insight studio belum tersedia.</p>
                    @endforelse
                </div>
            </section>

            {{-- AGENDA HARI INI --}}
            <section class="owner-panel-v2 owner-side-panel">
                <div class="owner-section-head small">
                    <div>
                        <span class="section-kicker">Jadwal</span>
                        <h2>Agenda Hari Ini</h2>
                    </div>
                </div>

                <div class="owner-agenda-list">
                    @forelse ($jadwalHariIni as $agenda)
                        <div class="owner-agenda-item">
                            <div class="owner-agenda-time">
                                {{ $agenda->jam_reservasi ? substr($agenda->jam_reservasi, 0, 5) : '-' }}
                            </div>

                            <div class="owner-agenda-content">
                                <strong>{{ $agenda->nama_pelanggan }}</strong>
                                <span>
                                    {{ $agenda->paket_foto }}
                                    •
                                    {{ $agenda->tanggal_reservasi ? \Carbon\Carbon::parse($agenda->tanggal_reservasi)->format('d M Y') : '-' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="owner-note-box">
                            <p>Belum ada agenda reservasi untuk hari ini.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- CATATAN OWNER --}}
            <section class="owner-panel-v2 owner-side-panel">
                <div class="owner-section-head small">
                    <div>
                        <span class="section-kicker">Informasi</span>
                        <h2>Catatan Owner</h2>
                    </div>
                </div>

                <div class="owner-note-box">
                    <p>
                        Beranda owner difokuskan untuk menampilkan ringkasan studio,
                        statistik utama, agenda hari ini, dan preview reservasi terbaru.
                        Pengelolaan data lengkap tetap dilakukan melalui menu Reservasi.
                    </p>
                </div>
            </section>

        </aside>
    </section>
</main>
@endsection
