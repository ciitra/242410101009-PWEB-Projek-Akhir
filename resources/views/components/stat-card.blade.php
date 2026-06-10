@props(['judul', 'nilai', 'ikon', 'warna'])

<div class="stat-card-component {{ $warna }}">
    <div class="stat-card-icon">
        {{ $ikon }}
    </div>

    <div class="stat-card-info">
        <h3>{{ $judul }}</h3>
        <p>{{ $nilai }}</p>
    </div>
</div>
