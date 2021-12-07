<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>{{ __('language-builder::builder.title') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @include('language-builder::css')
        <style type="text/css">
            body.dark {
              --bg-color: #000;
              --bg-secondary-color: #131316;
              --font-color: #f5f5f5;
              --color-grey: #ccc;
              --color-darkGrey: #777;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <nav class="nav">
                <div class="nav-left">
                    <a class="brand" href="#">{{ __('language-builder::builder.title') }}</a>
                </div>
                <div class="nav-right" style="margin: 0;">
                  <a href="javascript:void(0)" onclick="switchMode(this)">☀️</a>
                </div>
            </nav>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <form class="" action="{{ url('language-builder/build') }}" method="POST">
                            <header>
                                <h4>{{ __('language-builder::builder.intro_message') }}</h4>
                            </header>

                            <p>
                                <select name="translate">
                                    @foreach ($languages as $key => $value)
                                        <option value="{{ $key }}" selected="{{ (Input::get('translate') === $key) ? 'selected' : '' }}">
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </p>

                            <footer class="is-right">
                                <button type="submit" class="button success">
                                    {{ __('language-builder::builder.translate') }}
                                </button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <script>
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.body.classList.add('dark');
                document.querySelector('#theme-switch').innerHTML = '🌙'
            }

            function switchMode(el) {
                const bodyClass = document.body.classList;
                bodyClass.contains('dark')
                    ? ((el.innerHTML = '☀️'), bodyClass.remove('dark'))
                    : ((el.innerHTML = '🌙'), bodyClass.add('dark'));
            }
          </script>
    </body>
</html>
