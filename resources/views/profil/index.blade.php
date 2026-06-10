@extends('layouts.app')

@section('title', 'Profil Owner - Studio LensArt')

@section('content')
<section class="profil-owner-section">
    <div class="profil-owner-header">
        <div>
            <h1 class="section-title">Profil Owner</h1>
        </div>

        <a href="{{ route('reservasi.index') }}" class="btn-secondary">
            Kembali ke Reservasi
        </a>
    </div>

    @if ($errors->any())
        <div class="form-message error reservasi-error-box">
            <strong>Profil belum berhasil diperbarui.</strong>
            <p>Silakan periksa kembali input yang ditandai.</p>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profil-owner-card">
        <div class="profil-photo-preview">
            @if ($profil->foto)
                <img src="{{ asset('storage/' . $profil->foto) }}" alt="Foto Profil Owner">
            @else
                <div class="profil-photo-empty">
                    Belum ada foto profil
                </div>
            @endif

            <h2>{{ $profil->nama_owner }}</h2>
            <p>{{ $profil->nama_studio }}</p>
            <span>{{ $profil->email }}</span>
        </div>

        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="profil-owner-form">
            @csrf
            @method('PUT')

            <div class="form-section-title">
                <h2>Informasi Owner</h2>
                <p>Perbarui data owner dan upload foto profil.</p>
            </div>

            <div class="form-group">
                <label for="nama_owner">Nama Owner</label>
                <input
                    type="text"
                    name="nama_owner"
                    id="nama_owner"
                    value="{{ old('nama_owner', $profil->nama_owner) }}"
                    class="{{ $errors->has('nama_owner') ? 'input-error' : '' }}"
                >
                @error('nama_owner')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Owner</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $profil->email) }}"
                    class="{{ $errors->has('email') ? 'input-error' : '' }}"
                >
                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama_studio">Nama Studio</label>
                <input
                    type="text"
                    name="nama_studio"
                    id="nama_studio"
                    value="{{ old('nama_studio', $profil->nama_studio) }}"
                    class="{{ $errors->has('nama_studio') ? 'input-error' : '' }}"
                >
                @error('nama_studio')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="foto">Foto Profil Owner</label>
                <input
                    type="file"
                    name="foto"
                    id="foto"
                    class="{{ $errors->has('foto') ? 'input-error' : '' }}"
                >
                <small class="form-help">Opsional. Format JPG atau PNG. Maksimal 2MB.</small>
                @error('foto')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="reservasi-form-actions">
                <a href="{{ route('profil.index') }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn-create">
                    Update Profil
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
