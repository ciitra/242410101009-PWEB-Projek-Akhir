@extends('layouts.guest')

@section('title', 'Lupa Password - Studio LensArt')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-brand">
            <img src="{{ asset('images/logo-lensart.png') }}" alt="Logo Studio LensArt">

            <h1>Lupa Password</h1>

            <p>
                Masukkan email akun Studio LensArt anda. Sistem akan mengirimkan
                link reset password ke email anda.
            </p>
        </div>

        @if (session('status'))
            <div class="auth-alert success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="auth-alert error">
                <strong>Terjadi kesalahan.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="auth-form-group">
                <label for="email">Email</label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required
                    autofocus
                >
            </div>

            <button type="submit" class="auth-submit">
                Kirim Link Reset Password
            </button>

            <p class="auth-switch">
                Ingat password?
                <a href="{{ route('login') }}">Kembali ke Login</a>
            </p>
        </form>
    </div>
</div>
@endsection
