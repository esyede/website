@layout('layouts.main')

@section('stats')
    <div class="band"{!! isset($news) ? ' id="news"' : '' !!}>
        <div class="shell shell--flush">
            <div class="cells cells--3">
                <div class="stat">
                    <span class="stat__num">5.4 &rarr; 8.x</span>
                    <span class="stat__label">PHP supported</span>
                </div>
                <div class="stat">
                    <span class="stat__num">&lt; 1 MB</span>
                    <span class="stat__label">Zipped, docs included</span>
                </div>
                <div class="stat">
                    <span class="stat__num">MIT</span>
                    <span class="stat__label">License</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('features')
    <div class="band">
        <div class="shell">
            <div class="band__head">
                <span class="eyebrow">Why Rakit</span>
                <h2>A framework that stays out of your way</h2>
                <p>Everything below ships in the box. No package hunting, no build step.</p>
            </div>
        </div>
        <div class="shell shell--flush">
            <div class="cells cells--4">
                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path
                                d="M13 2 L13 6 11 7 8 4 4 8 7 11 6 13 2 13 2 19 6 19 7 21 4 24 8 28 11 25 13 26 13 30 19 30 19 26 21 25 24 28 28 24 25 21 26 19 30 19 30 13 26 13 25 11 28 8 24 4 21 7 19 6 19 2 Z" />
                            <circle cx="16" cy="16" r="4" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Strong foundation</h3>
                    <p class="cell__text">A mature code base and a sensible approach to writing web applications,
                        so you build on something solid instead of assembling it yourself.</p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path d="M18 13 L26 2 8 13 14 19 6 30 24 19 Z" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Get started quickly</h3>
                    <p class="cell__text">No convoluted installation procedure. Download and extract, or pull it in
                        with Composer &mdash; either way you are running in minutes.</p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path d="M10 9 L3 17 10 25 M22 9 L29 17 22 25 M18 7 L14 27" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Less writing</h3>
                    <p class="cell__text">Light, modular and fast. Rakit is easy enough to learn that onboarding
                        does not turn into a training budget.</p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path
                                d="M4 14 L4 30 28 30 28 14 M2 9 L2 14 30 14 30 9 2 9 Z M16 9 C 16 9 14 0 8 3 2 6 16 9 16 9 16 9 18 0 24 3 30 6 16 9 16 9" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Complete features</h3>
                    <p class="cell__text">Fast URL routing, multi-protocol cache drivers, a powerful database
                        abstraction layer and support for multilingual applications.</p>
                </article>
            </div>
        </div>
    </div>
@endsection

@section('involve')
    <div class="band">
        <div class="shell shell--flush">
            <div class="cells cells--3">
                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path d="M6 2 L6 30 M6 6 L26 6 20 12 26 18 6 18" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Let's start</h3>
                    <p class="cell__text">It's time to start developing web applications the easy way.</p>
                    <p class="cell__action">
                        <a class="btn btn--primary btn--sm" href="{{ url('download') }}">Download {{ RAKIT_VERSION }}</a>
                    </p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 64 64" aria-hidden="true">
                            <path stroke-width="0" fill="currentColor"
                                d="M32 0 C14 0 0 14 0 32 0 53 19 62 22 62 24 62 24 61 24 60 L24 55 C17 57 14 53 13 50 13 50 13 49 11 47 10 46 6 44 10 44 13 44 15 48 15 48 18 52 22 51 24 50 24 48 26 46 26 46 18 45 12 42 12 31 12 27 13 24 15 22 15 22 13 18 15 13 15 13 20 13 24 17 27 15 37 15 40 17 44 13 49 13 49 13 51 20 49 22 49 22 51 24 52 27 52 31 52 42 45 45 38 46 39 47 40 49 40 52 L40 60 C40 61 40 62 42 62 45 62 64 53 64 32 64 14 50 0 32 0 Z" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Repositories</h3>
                    <p class="cell__text">Join us on
                        <a href="https://github.com/esyede/rakit" target="_blank">Github</a>
                        to make rakit even better.</p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path d="M2 4 L30 4 30 22 16 22 8 29 8 22 2 22 Z" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Forum</h3>
                    <p class="cell__text">Having trouble getting started, or want to share your thoughts? Talk with
                        other developers at the
                        <a href="https://github.com/esyede/rakit/discussions" target="_blank">discussion forum</a>.</p>
                </article>
            </div>
        </div>
    </div>
@endsection

@section('packages')
    <div class="band">
        <div class="cta">
            <span class="eyebrow">Package repository</span>
            <h2>Download and share your package</h2>
            <p>Browse what the community has built, or publish your own.</p>
            <a class="btn btn--primary" href="{{ url('repositories') }}">
                <svg class="btn__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M19 19 L28 28" />
                </svg>
                Find a package
            </a>
        </div>
    </div>
@endsection

@section('main')
    @yield('stats')
    @yield('features')
    @yield('involve')
    @yield('packages')
@endsection
