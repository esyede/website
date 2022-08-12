<footer class="footer">
    <div class="container">
        <div class="content has-text-centered">
            <p>{!! __('home.footer.credit', [
                'love' => '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11" height="11" viewBox="0 0 16 16">
                <path fill="#f14668" d="M11.8 1c-1.682 0-3.129 1.368-3.799 2.797-0.671-1.429-2.118-2.797-3.8-2.797-2.318 0-4.2 1.882-4.2 4.2 0 4.716 4.758 5.953 8 10.616 3.065-4.634 8-6.050 8-10.616 0-2.319-1.882-4.2-4.2-4.2z">
                </path>
                </svg>',
                'contributors' => '<a href="https://github.com/esyede/rakit/contributors" target="_blank">'.__('home.footer.contributors').'</a>',
                'license' => '<a href="http://opensource.org/licenses/mit-license.php" target="_blank">'.__('home.footer.license').'</a>',
            ]) !!}</p>
        </div>
    </div>
</footer>
<script type="text/javascript" src="{{ asset('main/js/main.min.js?v='.RAKIT_VERSION) }}"></script>
<script type="text/javascript">
    var news = document.getElementById('news');
    if (news != null) {
        bulmaToast.toast({
            message: '{!! isset($news) ? '<small>'.$news.'</small>' : '' !!}',
            type: 'is-dark',
            duration: 7000,
            closeOnClick: true,
            dismissible: true,
            opacity: .8,
            position: 'bottom-center',
            animate: { in: 'heartBeat', out: 'backOutDown' }
        });
    }
</script>
