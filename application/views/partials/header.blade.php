<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Runs before the first paint, so a light-theme visitor never sees the
         dark default flash past. The markup ships with class="dark". --}}
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('theme');
                var light = saved
                    ? saved === 'light'
                    : window.matchMedia('(prefers-color-scheme: light)').matches;

                document.documentElement.classList.toggle('dark', !light);
            } catch (e) {}
        })();
    </script>

    <title>Rakit :: {{ $page }}</title>
    <meta name="description" content="Rakit :: A simple, lightweight and modular PHP framework.">
    <meta name="color-scheme" content="dark light">
    <meta name="theme-color" content="#09090b" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <link rel="icon" type="image/png" href="data:;base64,iVBORw0KGgo=">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Geist:wght@300..700&family=Geist+Mono:wght@400..600&display=swap">

    <link rel="stylesheet" href="{{ asset('main/css/main.css?v=' . RAKIT_VERSION) }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Rakit :: {{ $page }}">
    <meta property="og:description" content="A simple, lightweight and modular PHP framework.">
    <meta property="og:site_name" content="Rakit :: {{ $page }}">
</head>
