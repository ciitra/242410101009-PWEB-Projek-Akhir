@extends('layouts.app')

@section('title', 'Profil Customer - Studio LensArt')

@section('content')
<section class="profil-owner-section">
    <div class="profil-owner-header">
        <div>
            <h1 class="section-title">Profil Customer</h1>
            <p class="section-desc">
                Kelola data akun customer Studio LensArt milik Anda.
            </p>
        </div>

        <a href="{{ route('customer.dashboard') }}" class="btn-secondary">
            Kembali
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
            <div class="profil-photo-empty profil-customer-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <h2>{{ auth()->user()->name }}</h2>
            <p>{{ auth()->user()->email }}</p>
            <span>Role: {{ auth()->user()->role }}</span>
        </div>

        <form action="{{ route('customer.profil.update') }}" method="POST" class="profil-owner-form">
            @csrf
            @method('PUT')

            <div class="form-section-title">
                <h2>Data Akun</h2>
                <p>Perbarui nama dan email akun customer Anda.</p>
            </div>

            <div class="form-group">
                <label for="name">Nama Customer</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', auth()->user()->name) }}"
                    class="{{ $errors->has('name') ? 'input-error' : '' }}"
                >
                @error('name')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Customer</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', auth()->user()->email) }}"
                    class="{{ $errors->has('email') ? 'input-error' : '' }}"
                >
                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="reservasi-form-actions">
                <a href="{{ route('customer.dashboard') }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn-create">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
