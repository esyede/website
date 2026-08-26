<!DOCTYPE html>
<html lang="{{ config('application.language') }}" class="dark">

@include('partials.header')

<body>
    @include('partials.navbar')

    <main class="main">
        @if (System\Str::starts_with($page, 'Home'))
            @include('partials.hero_home')
        @else
            @include('partials.hero_pages')
        @endif

        @yield('main')
    </main>

    @include('partials.footer')
</body>

</html>
