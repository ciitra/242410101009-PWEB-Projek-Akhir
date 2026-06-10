<x-guest-layout>
    <div class="auth-card">
        <div class="auth-brand">
            <img src="{{ asset('images/logo-lensart.png') }}" alt="Logo Studio LensArt">
            <h1>Register</h1>
            <p>Buat akun untuk mengakses sistem reservasi Studio LensArt.</p>
        </div>

        @if ($errors->any())
            <div class="auth-alert error">
                <strong>Registrasi belum berhasil.</strong>
                <p>Silakan periksa kembali data yang dimasukkan.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="auth-form-group">
                <label for="name">Nama</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Masukkan nama"
                    class="{{ $errors->has('name') ? 'input-error' : '' }}"
                >
                @error('name')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="email">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="Masukkan email"
                    class="{{ $errors->has('email') ? 'input-error' : '' }}"
                >
                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Masukkan password"
                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                >
                @error('password')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                    class="{{ $errors->has('password_confirmation') ? 'input-error' : '' }}"
                >
                @error('password_confirmation')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="auth-submit">
                Register
            </button>

            <p class="auth-switch">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login di sini</a>
            </p>
        </form>
    </div>
</x-guest-layout>
