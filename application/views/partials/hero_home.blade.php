<section class="hero">
    @include('partials.hero_bg')

    <span class="hero__badge">Latest release &mdash; <b>{{ RAKIT_VERSION }}</b></span>
    <h1 class="hero__title">
        A <em>simple, lightweight</em><br>
        and modular PHP framework.
    </h1>
    <p class="hero__lead">
        Fast URL routing, multi-protocol cache drivers, a database abstraction layer and
        authentication &mdash; all included. Runs on PHP 5.4 through 8.x.
    </p>
    <div class="hero__actions">
        <a class="btn btn--primary" href="{{ url('download') }}">
            <svg class="btn__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 4 L16 22 M8 16 L16 24 24 16 M4 28 L28 28" />
            </svg>
            Download {{ RAKIT_VERSION }}
        </a>
        <a class="btn btn--ghost" href="{{ url('docs') }}">Read the docs</a>
    </div>
    <div class="hero__cmd">
        <code data-copy="composer create-project esyede/rakit"><span class="prompt">$</span> composer create-project esyede/rakit</code>
        <button type="button" class="copy" data-copy="composer create-project esyede/rakit"
            aria-label="Copy the install command">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                stroke-linejoin="round" aria-hidden="true">
                <rect x="9" y="9" width="12" height="12" />
                <path d="M5 15 L3 15 3 3 15 3 15 5" />
            </svg>
        </button>
    </div>
</section>
