<footer class="footer">
    <div class="shell shell--flush">
        <div class="footer__grid">
            <div class="footer__col">
                <a class="footer__brand" href="{{ URL::home() }}">Rakit</a>
                <p class="footer__credit">
                    Made with
                    <svg width="11" height="11" viewBox="0 0 16 16" aria-hidden="true">
                        <path fill="currentColor"
                            d="M11.8 1c-1.682 0-3.129 1.368-3.799 2.797-0.671-1.429-2.118-2.797-3.8-2.797-2.318 0-4.2 1.882-4.2 4.2 0 4.716 4.758 5.953 8 10.616 3.065-4.634 8-6.050 8-10.616 0-2.319-1.882-4.2-4.2-4.2z" />
                    </svg>
                    by awesome
                    <a href="https://github.com/esyede/rakit/contributors" target="_blank">Contributors</a>.
                    Released under the
                    <a href="http://opensource.org/licenses/mit-license.php" target="_blank">MIT License</a>.
                </p>
            </div>
            <div class="footer__col">
                <h4>Resources</h4>
                <a href="{{ url('docs') }}">Documentation</a>
                <a href="{{ url('api/main/index.html') }}" target="_blank">API Reference</a>
                <a href="{{ url('repositories') }}">Packages</a>
            </div>
            <div class="footer__col">
                <h4>Community</h4>
                <a href="https://github.com/esyede/rakit/discussions" target="_blank">Forum</a>
                <a href="https://github.com/esyede/rakit" target="_blank">Github</a>
                <a href="https://github.com/esyede/rakit/contributors" target="_blank">Contributors</a>
            </div>
            <div class="footer__col">
                <h4>Get started</h4>
                <a href="{{ url('download') }}">Download {{ RAKIT_VERSION }}</a>
                <a href="{{ url('docs/install') }}">Installation</a>
                <a href="{{ url('docs/changelog') }}">Release notes</a>
            </div>
        </div>
    </div>
    <p class="footer__base">Rakit {{ RAKIT_VERSION }} &mdash; PHP 5.4 to 8.x</p>
</footer>

<script type="text/javascript" src="{{ asset('main/js/main.min.js?v=' . RAKIT_VERSION) }}"></script>
<script type="text/javascript">
    var news = document.getElementById('news');
    if (news != null) {
        bulmaToast.toast({
            message: '{!! isset($news) ? '<small>' . $news . '</small>' : '' !!}',
            type: 'is-dark',
            duration: 7000,
            closeOnClick: true,
            dismissible: true,
            opacity: .8,
            position: 'bottom-center',
            animate: {
                in: 'fadeInUp',
                out: 'fadeOutDown'
            }
        });
    }
</script>

<script type="text/javascript">
    (function () {
        var button = document.getElementById('themeToggle');

        if (!button) {
            return;
        }

        button.addEventListener('click', function () {
            var root = document.documentElement;
            var dark = !root.classList.contains('dark');

            root.classList.toggle('dark', dark);

            try {
                localStorage.setItem('theme', dark ? 'dark' : 'light');
            } catch (e) {}
        });
    })();
</script>
