<header class="nav">
    <div class="shell nav__inner">
        <div class="nav__left">
            <a class="nav__brand" href="{{ URL::home() }}">Rakit</a>
            <nav id="navMenuMore" class="nav__links">
                <a class="nav__link{{ System\Str::starts_with($page, 'Home') ? ' is-current' : '' }}"
                    href="{{ URL::home() }}">Home</a>
                <a class="nav__link" href="{{ url('docs') }}">Docs</a>
                <a class="nav__link{{ System\Str::starts_with($page, 'Repositories') ? ' is-current' : '' }}"
                    href="{{ url('repositories') }}">Packages</a>
                <a class="nav__link" href="{{ url('api/main/index.html') }}" target="_blank">API</a>
                <a class="nav__link" href="https://github.com/esyede/rakit/discussions" target="_blank">Forum</a>
                <a class="nav__link" href="https://github.com/esyede/rakit" target="_blank">Github</a>
            </nav>
        </div>
        <div class="nav__right">
            <button type="button" class="theme-toggle" id="themeToggle" title="Toggle theme"
                aria-label="Toggle theme">
                <svg class="theme-toggle__moon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
                </svg>
                <svg class="theme-toggle__sun" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="4" />
                    <path
                        d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41" />
                </svg>
            </button>
            <a class="btn btn--primary btn--sm nav__cta" href="{{ url('download') }}">Download</a>
            <button type="button" class="navbar-burger" data-target="navMenuMore" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>
