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
                <div class="col-4">
                    <div class="card">
                        @if (isset($files))
                            <h4>{{ __('language-builder::builder.missing_translations') }}</h4>
                            <ul>
                                @if (isset($files['app']['missing']))
                                    @foreach ($files['app']['missing'] as $file)
                                        <li>{!! Esyede\LanguageBuilder\Utilities::link($file) !!}</li>
                                    @endforeach
                                @endif

                                @if (isset($files['packages']['missing']))
                                    @foreach ($files['packages']['missing'] as $file)
                                        <li>{!! Esyede\LanguageBuilder\Utilities::link($file) !!}</li>
                                    @endforeach
                                @endif
                            </ul>

                            <hr>

                            <h4>{{ __('language-builder::builder.all_translation_files') }}</h4>
                            <ul>
                                @if (isset($files['app']['all']))
                                    @foreach ($files['app']['all'] as $file)
                                        <li>{!! Esyede\LanguageBuilder\Utilities::link($file) !!}</li>
                                    @endforeach
                                @endif

                                @if (isset($files['packages']['all']))
                                    @foreach ($files['packages']['all'] as $file)
                                        <li>{!! Esyede\LanguageBuilder\Utilities::link($file) !!}</li>
                                    @endforeach
                                @endif
                            </ul>
                        @endif

                    </div>
                </div>

                <div class="col-8">
                    <div class="card">

                        @if (isset($edit))

                                <form class="form-horizontal" action="{{ url('language-builder/update') }}" method="POST">
                                    <input type="hidden" name="location" value="{{ Input::get('location') }}">
                                    <input type="hidden" name="name" value="{{ Input::get('name') }}">
                                    <input type="hidden" name="translate" value="{{ Input::get('translate') }}">

                                    @foreach ($edit['from'] as $key => $string)
                                        @if (is_array($string) && ! empty($string))
                                            @foreach ($string as $sub_key => $sub_value)
                                                <fieldset>
                                                    <legend class="text-error">{{ $lang_file.'.'.$key.'.'.$sub_key }}</legend>
                                                    <div class="grouped">
                                                        <span>{{ strtoupper($base_lang) }}</span>
                                                        <span class="text-success">{{ $edit['from'][$key][$sub_key] }}</span>
                                                    </div>
                                                    <p></p>
                                                    <div class="grouped">
                                                        <span>{{ strtoupper(Input::get('translate')) }}</span>
                                                        <p></p>
                                                        <input type="text" name="lang[{{ $key }}][{{ $sub_key }}]" value="{{ $edit['to'][$key][$sub_key] or '' }}">
                                                    </div>
                                                </fieldset>
                                                <p></p>
                                            @endforeach

                                        @elseif (! empty($string))

                                            <fieldset>
                                                <legend class="text-error">{{ $lang_file.'.'.$key }}</legend>
                                                <div class="grouped">
                                                    <span>{{ strtoupper($base_lang) }}</span>
                                                    <span class="text-success">{{ $string }}</span>
                                                </div>
                                                <p></p>
                                                <div class="grouped">
                                                    <span>{{ strtoupper(Input::get('translate')) }}</span>
                                                    <p></p>
                                                    <input type="text" name="lang[{{ $key }}]" value="{{ $edit['to'][$key] or '' }}">
                                                </div>
                                            </fieldset>
                                            <p></p>
                                        @endif
                                    @endforeach

                                    <p>
                                        <footer class="is-right">
                                            <a href="{{ url('/language-builder/edit?translate='.Input::get('translate')) }}" type="button" class="button error">
                                                {{ __('language-builder::builder.back') }}
                                            </a>
                                            <button type="submit" class="button success">
                                                {{ __('language-builder::builder.save_changes') }}
                                            </button>
                                        </footer>
                                    </p>
                                </form>
                            </fieldset>

                        @else

                        <blockquote>
                            {{ __('language-builder::builder.select_file') }}
                        </blockquote>

                        @endif
                    </div>
                </div>
            </div>

            <footer></footer>
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
