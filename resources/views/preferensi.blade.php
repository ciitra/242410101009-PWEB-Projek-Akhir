@extends('layouts.app')

@section('title', 'Preferensi Tampilan - Studio LensArt')

@section('content')
<section class="preference-simple-section">
    <div class="preference-simple-card">
        <div class="preference-simple-header">
            <h1>⚙️ Pengaturan Preferensi</h1>
            <p>Sesuaikan tampilan Studio LensArt senyaman mungkin untuk Anda.</p>
        </div>

        <form id="preferenceForm" class="preference-simple-form">
            <div class="form-group">
                <label for="themePreference">Pilih Tema Aplikasi</label>
                <select name="theme" id="themePreference">
                    <option value="light">Terang (Light)</option>
                    <option value="dark">Gelap (Dark)</option>
                    <option value="system">Ikuti Sistem (System)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fontPreference">Ukuran Teks</label>
                <select name="font_size" id="fontPreference">
                    <option value="small">Kecil</option>
                    <option value="normal">Sedang</option>
                    <option value="large">Besar</option>
                </select>
            </div>

            <div class="preference-simple-actions">
                <button type="submit" class="btn-create">
                    Simpan Preferensi
                </button>

                <button type="button" class="btn-secondary" id="resetPreferenceButton">
                    Reset
                </button>
            </div>

            <p id="preferenceMessage" class="preference-simple-message">
                Preferensi akan disimpan di cookie browser.
            </p>
        </form>
    </div>
</section>
@endsection
