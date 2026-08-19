@layout('layouts.main')

@section('howto')
    <div id="modal-dialog-howto" class="modal is-clipped">
        <div class="modal-background"></div>
        <div class="modal-content">
            <section class="modal-card-body">
                <p>Installing <i class="has-text-success">notyf</i> package:</p>
                <p>
                    <pre><code>php rakit package:install notyf</code></pre>
                </p>
                <br>
                <p>Manual installation:</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                        1. Download the <span class="has-text-danger">notyf</span> package<br>
                        2. Extract it to the <span class="has-text-danger">packages/</span> folder<br>
                        3. If the package has assets, copy the assets to
                        <span class="has-text-danger">assets/packages/notyf/</span><br>
                    </small>
                </p>
                <br>
                <button class="button is-info" id="modal-close-howto">Okay, Got it!</button>
            </section>
        </div>
    </div>
@endsection

@section('add-package')
    <div id="modal-dialog-add-package" class="modal is-clipped">
        <div class="modal-background"></div>
        <div class="modal-content">
            <section class="modal-card-body">
                <p>How to share a package:</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                        1. Login to Github and edit the
                        <a href="https://github.com/esyede/rakit/edit/master/repositories.json"
                            target="_blank">repositories.json</a>
                        file to add your package data.<br>
                        2. Send a pull request of changes you made.<br>
                        3. Create a new thread in the
                        <a href="https://github.com/esyede/rakit/discussions" target="_blank">Paket &amp; library</a>
                        subforum and explain the details.<br>
                    </small>
                </p>
                <p>Releasing a new version:</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                        1. Repeat the steps "How to share a package" above.<br>
                        2. Edit first post of your thread and add details of the new version.<br>
                    </small>
                </p>
                <br>
                <button class="button is-success" id="modal-close-add-package">Okay, Got it!</button>
            </section>
        </div>
    </div>
@endsection

@section('pages_title')
    <br>
    <h1 class="title">Package Repository</h1>
    <p class="subtitle">Download and share your package with other developers</p>
    <div class="buttons is-block">
        <button id="show-modal-howto" class="button is-info">How to Install?</button>
        <button id="show-modal-add-package" class="button is-success">Share a Package</button>
    </div>
    @yield('howto')
    @yield('add-package')
    <br>
@endsection

@section('listings')
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-3-desktop is-3-tablet">
                    <aside class="menu">
                        <p class="menu-label">Categories</p>
                        <ul class="menu-list">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ url('repositories/' . System\Str::slug($category['name'])) }}">
                                        {{ System\Str::title($category['name']) }}
                                        <span class="tag is-info is-light is-rounded">
                                            {{ $category['count'] }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <a href="{{ url('repositories') }}">All
                                    <span class="tag is-info is-light is-rounded">
                                        {{ $count }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </aside>
                </div>
                <div class="column is-9-desktop is-9-tablet">
                    <div class="container">
                        <p class="menu-label is-size-6">{{ $category['name'] }}</p>
                        <br>
                        @for ($i = 0; $i < count($packages); $i++)
                            <div class="box">
                                <article class="media">
                                    <div class="media-left">
                                        <figure class="image is-64x64">
                                            <img src="{{ asset('main/images/package.png') }}" alt="paket">
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <div class="content">
                                            <div class="is-pulled-right is-hidden-mobile">
                                                @if ($packages[$i]['maintained'])
                                                    <span class="button is-success is-rounded is-small"
                                                        title="This package is still being maintained">maintained</span>
                                                @else
                                                    <span class="button is-warning is-rounded is-small"
                                                        title="This package is unmaintained">unmaintained</span>
                                                @endif
                                            </div>
                                            <p>
                                                <a class="is-size-4" title="Visit package&#039;s repository"
                                                    href="{{ $packages[$i]['repository'] }}"
                                                    target="_blank">{{ $packages[$i]['name'] }}</a>
                                                <br>
                                                {!! nl2br($packages[$i]['description']) !!}
                                            </p>
                                            <br>
                                            <div class="is-pulled-left">
                                                <a class="tag is-small is-primary"
                                                    href="{{ url('repositories/' . System\Str::slug($packages[$i]['category'])) }}"
                                                    title="Kategori: {{ $packages[$i]['category'] }}">{{ System\Str::title($packages[$i]['category']) }}</a>
                                            </div>
                                            <span class="is-pulled-right is-size-7">
                                                Compatible:
                                                {{ implode(', ', array_keys($packages[$i]['compatibilities'])) }}
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endfor

                        <nav class="pagination is-rounded" role="navigation">
                            @if ($current > 1)
                                <a class="pagination-previous" href="?page={{ $current - 1 }}">&laquo;
                                    Previous</a>
                            @else
                                <a class="pagination-previous" href="#" disabled>&laquo;
                                    Previous</a>
                            @endif

                            @if ($current < $last)
                                <a class="pagination-next" href="?page={{ $current + 1 }}">Next
                                    &raquo;</a>
                            @else
                                <a class="pagination-next" href="#" disabled>Next
                                    &raquo;</a>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('main')
    @yield('listings')
@endsection
