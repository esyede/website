<header class="nav">
    <div class="shell nav__inner">
        <div class="nav__left">
            <a class="nav__brand" href="{{ URL::home() }}">Rakit</a>
            <nav id="navMenuMore" class="nav__links">
                <a class="nav__link{{ System\Str::starts_with($page, 'Home') ? ' is-current' : '' }}"
                    href="{{ URL::home() }}">Home</a>
                <a class="nav__link" href="{{ url('docs') }}">Docs</a>
                <a class="nav__link" href="{{ url('api/main/index.html') }}" target="_blank">API</a>
                <a class="nav__link{{ System\Str::starts_with($page, 'Repositories') ? ' is-current' : '' }}"
                    href="{{ url('repositories') }}">Packages</a>
                <a class="nav__link" href="https://github.com/esyede/rakit/discussions" target="_blank">Forum</a>
                <a class="nav__link" href="https://github.com/esyede/rakit" target="_blank">Github</a>
            </nav>
        </div>
        <div class="nav__right">
            <a class="btn btn--primary btn--sm nav__cta" href="{{ url('download') }}">Download</a>
            <button type="button" class="navbar-burger" data-target="navMenuMore" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>
