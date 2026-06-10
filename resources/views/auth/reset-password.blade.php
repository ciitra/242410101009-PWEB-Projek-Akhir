@extends('layouts.guest')

@section('title', 'Reset Password - Studio LensArt')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-brand">
            <img src="{{ asset('images/logo-lensart.png') }}" alt="Logo Studio LensArt">

            <h1>Reset Password</h1>

            <p>
                Masukkan password baru untuk akun Studio LensArt Anda.
            </p>
        </div>

        @if ($errors->any())
            <div class="auth-alert error">
                <strong>Reset password belum berhasil.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" class="auth-form">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="auth-form-group">
                <label for="email">Email</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan email"
                    class="{{ $errors->has('email') ? 'input-error' : '' }}"
                >

                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password">Password Baru</label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Masukkan password baru"
                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                >

                @error('password')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                >
            </div>

            <button type="submit" class="auth-submit">
                Simpan Password Baru
            </button>

            <p class="auth-switch">
                Sudah ingat password?
                <a href="{{ route('login') }}">Kembali ke Login</a>
            </p>
        </form>
    </div>
</div>
@endsection
