@if (Session::has('noty.messages'))
    <script type="text/javascript">
        (function () {
            var notyf = new Notyf();
            @foreach (Session::get('noty.messages', []) as $item)
            notyf.{{ $item['type'] }}("{{ $item['message'] }}");
            @endforeach
        })();
    </script>
@endif
