<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Studio LensArt')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-lensart.png') }}">

    <script>
        (function () {
            const cookies = document.cookie.split('; ');

            const themeCookie = cookies.find((row) => row.startsWith('theme='));
            const fontCookie = cookies.find((row) => row.startsWith('font_size='));

            const theme = themeCookie ? themeCookie.split('=')[1] : '';
            const fontSize = fontCookie ? fontCookie.split('=')[1] : 'normal';

            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }

            if (theme === 'light') {
                document.documentElement.classList.remove('dark');
            }

            if (theme === 'system') {
                const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (systemDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }

            document.documentElement.classList.remove('font-small', 'font-normal', 'font-large');

            if (fontSize === 'small') {
                document.documentElement.classList.add('font-small');
            } else if (fontSize === 'large') {
                document.documentElement.classList.add('font-large');
            } else {
                document.documentElement.classList.add('font-normal');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    @include('partials.navbar')

    @if (session('success'))
        <div class="flash-message flash-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flash-message flash-error">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
