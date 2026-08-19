@layout('layouts.main')

@section('howto')
    <div id="modal-dialog-howto" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <h3 class="modal__title">How to install a package</h3>

            <p class="modal__lead">Installing the <span class="hl">notyf</span> package:</p>
            <div class="code">
                <div class="code__bar">
                    <span class="code__dot"></span>
                    <span class="code__dot"></span>
                    <span class="code__dot"></span>
                    <span class="code__name">terminal</span>
                </div>
                <pre><code><span class="prompt">$</span> php rakit package:install <span class="arg">notyf</span></code></pre>
            </div>

            <p class="modal__lead">Or install it manually:</p>
            <ol class="modal__steps">
                <li>Download the <span class="hl">notyf</span> package</li>
                <li>Extract it to the <span class="hl">packages/</span> folder</li>
                <li>If the package has assets, copy them to <span class="hl">assets/packages/notyf/</span></li>
            </ol>

            <div class="modal__actions">
                <button type="button" class="btn btn--primary" id="modal-close-howto">Okay, got it</button>
            </div>
        </div>
    </div>
@endsection

@section('add-package')
    <div id="modal-dialog-add-package" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <h3 class="modal__title">Share a package</h3>

            <p class="modal__lead">How to share a package:</p>
            <ol class="modal__steps">
                <li>Login to Github and edit the
                    <a href="https://github.com/esyede/rakit/edit/master/repositories.json"
                        target="_blank">repositories.json</a>
                    file to add your package data.</li>
                <li>Send a pull request of the changes you made.</li>
                <li>Create a new thread in the
                    <a href="https://github.com/esyede/rakit/discussions" target="_blank">Paket &amp; library</a>
                    subforum and explain the details.</li>
            </ol>

            <p class="modal__lead">Releasing a new version:</p>
            <ol class="modal__steps">
                <li>Repeat the steps above.</li>
                <li>Edit the first post of your thread and add details of the new version.</li>
            </ol>

            <div class="modal__actions">
                <button type="button" class="btn btn--primary" id="modal-close-add-package">Okay, got it</button>
            </div>
        </div>
    </div>
@endsection

@section('pages_title')
    <span class="eyebrow">Package repository</span>
    <h1 class="hero__title">Packages built by the community</h1>
    <p class="hero__lead">Download and share your package with other developers.</p>
    <div class="hero__actions">
        <button type="button" id="show-modal-howto" class="btn btn--ghost">How to install?</button>
        <button type="button" id="show-modal-add-package" class="btn btn--primary">Share a package</button>
    </div>
    @yield('howto')
    @yield('add-package')
@endsection

@section('listings')
    <div class="band">
        <div class="shell">
            <div class="repo">
                <aside class="repo__side">
                    <h4 class="eyebrow">Categories</h4>
                    <a class="repo__cat{{ isset($category) ? '' : ' is-current' }}" href="{{ url('repositories') }}">
                        <span>All packages</span>
                        <span class="repo__count">{{ $count }}</span>
                    </a>
                    @foreach ($categories as $item)
                        <a class="repo__cat{{ isset($category) && $category === System\Str::slug($item['name']) ? ' is-current' : '' }}"
                            href="{{ url('repositories/' . System\Str::slug($item['name'])) }}">
                            <span>{{ System\Str::title($item['name']) }}</span>
                            <span class="repo__count">{{ $item['count'] }}</span>
                        </a>
                    @endforeach
                </aside>

                <div class="repo__list">
                    <div class="repo__bar">
                        <h2 class="cell__title">
                            {{ isset($category) ? System\Str::title(str_replace('-', ' ', $category)) : 'All packages' }}
                        </h2>
                        <span class="pager__status">Page {{ $current }} of {{ $last }}</span>
                    </div>

                    @for ($i = 0; $i < count($packages); $i++)
                        <article class="pkg">
                            <span class="pkg__logo" aria-hidden="true">
                                <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2">
                                    <path d="M16 3 L28 9 L28 23 L16 29 L4 23 L4 9 Z" />
                                    <path d="M4 9 L16 15 L28 9 M16 15 L16 29" />
                                </svg>
                            </span>
                            <div class="pkg__body">
                                <div class="pkg__head">
                                    <a class="pkg__name" title="Visit package&#039;s repository"
                                        href="{{ $packages[$i]['repository'] }}"
                                        target="_blank">{{ $packages[$i]['name'] }}</a>
                                    <a class="tag"
                                        href="{{ url('repositories/' . System\Str::slug($packages[$i]['category'])) }}">{{ $packages[$i]['category'] }}</a>
                                </div>
                                <p class="pkg__desc">{!! nl2br($packages[$i]['description']) !!}</p>
                                <div class="pkg__meta">
                                    @if ($packages[$i]['maintained'])
                                        <span><span class="dot"></span> maintained</span>
                                    @else
                                        <span><span class="dot dot--warn"></span> unmaintained</span>
                                    @endif
                                    <span>{{ implode(', ', array_keys($packages[$i]['compatibilities'])) }}</span>
                                </div>
                            </div>
                        </article>
                    @endfor

                    <nav class="pager">
                        @if ($current > 1)
                            <a class="pager__link" href="?page={{ $current - 1 }}">&larr; Previous</a>
                        @else
                            <span class="pager__link is-disabled">&larr; Previous</span>
                        @endif

                        <span class="pager__status">{{ $current }} / {{ $last }}</span>

                        @if ($current < $last)
                            <a class="pager__link" href="?page={{ $current + 1 }}">Next &rarr;</a>
                        @else
                            <span class="pager__link is-disabled">Next &rarr;</span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('main')
    @yield('listings')
@endsection
