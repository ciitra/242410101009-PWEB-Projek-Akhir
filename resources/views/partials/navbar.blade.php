<nav class="navbar">
    <div class="logo">Studio LensArt</div>

    <button class="menu-toggle" id="menuToggle" aria-label="Buka Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <ul class="nav-menu" id="navMenu">

        @auth
            @if (auth()->user()->role === 'owner')
                {{-- NAVBAR OWNER --}}
                <li>
                    <a href="{{ route('dashboard') }}#beranda" class="{{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                        Beranda
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard') }}#paket">
                        Paket Foto
                    </a>
                </li>

                <li>
                    <a href="{{ route('reservasi.index') }}" class="{{ request()->routeIs('reservasi.*') ? 'nav-active' : '' }}">
                        Reservasi
                    </a>
                </li>

                <li>
                    <a href="{{ route('profil.index') }}" class="{{ request()->routeIs('profil.*') ? 'nav-active' : '' }}">
                        Profil
                    </a>
                </li>

                <li>
                    <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'nav-active' : '' }}">
                        Tentang
                    </a>
                </li>

                <li>
                    <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'nav-active' : '' }}">
                        Kontak
                    </a>
                </li>

            @else
                {{-- NAVBAR CUSTOMER --}}
                <li>
                    <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'nav-active' : '' }}">
                        Beranda
                    </a>
                </li>

                <li>
                    <a href="{{ route('customer.dashboard') }}#paket-customer">
                        Paket Foto
                    </a>
                </li>

                <li>
                    <a href="{{ route('customer.reservasi.index') }}" class="{{ request()->routeIs('customer.reservasi.*') ? 'nav-active' : '' }}">
                        Reservasi
                    </a>
                </li>

                <li>
                    <a href="{{ route('customer.profil.edit') }}" class="{{ request()->routeIs('customer.profil.*') ? 'nav-active' : '' }}">
                        Profil
                    </a>
                </li>

                <li>
                    <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'nav-active' : '' }}">
                        Tentang
                    </a>
                </li>

                <li>
                    <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'nav-active' : '' }}">
                        Kontak
                    </a>
                </li>
            @endif

            {{-- MENU AUTH --}}
            <li>
                <a href="{{ route('preferensi') }}" class="{{ request()->routeIs('preferensi') ? 'nav-active' : '' }}">
                    Preferensi
                </a>
            </li>

            <li class="nav-user">
                <span class="nav-user-name">
                    <span class="nav-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>

                    <span>
                        Halo, {{ auth()->user()->name }}
                    </span>
                </span>
            </li>

            <li>
                <form action="{{ route('logout') }}" method="POST" class="nav-logout-form">
                    @csrf
                    <button type="submit" class="nav-logout-button">
                        Logout
                    </button>
                </form>
            </li>

            <li>
                <button type="button" class="nav-theme-toggle" id="themeToggleButton">
                    <span id="themeToggleIcon">🌙</span>
                </button>
            </li>

        @else
            {{-- NAVBAR GUEST / SEBELUM LOGIN --}}
            <li>
                <a href="{{ route('home') }}#beranda" class="{{ request()->routeIs('home') ? 'nav-active' : '' }}">
                    Beranda
                </a>
            </li>

            <li>
                <a href="{{ route('home') }}#paket-foto">
                    Paket Foto
                </a>
            </li>

            <li>
                <a href="{{ route('login') }}">
                    Reservasi
                </a>
            </li>

            <li>
                <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'nav-active' : '' }}">
                    Tentang
                </a>
            </li>

            <li>
                <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'nav-active' : '' }}">
                    Kontak
                </a>
            </li>

            <li>
                <a href="{{ route('preferensi') }}" class="{{ request()->routeIs('preferensi') ? 'nav-active' : '' }}">
                    Preferensi
                </a>
            </li>

            <li>
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'nav-active' : '' }}">
                    Login
                </a>
            </li>
        @endauth
    </ul>
</nav>
