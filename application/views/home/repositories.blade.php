@layout('layouts.main')

@section('howto')
    <div id="modal-dialog-howto" class="modal is-clipped">
        <div class="modal-background"></div>
        <div class="modal-content">
            <section class="modal-card-body">
                <p>{!! trans('repo.modal.install.text1', ['pkg' => '<i class="has-text-success">notyf</i>']) !!}</p>
                <p>
                    <pre><code>{{ trans('repo.modal.install.text2', ['pkg' => 'notyf']) }}</code></pre>
                </p>
                <br>
                <p>{{ trans('repo.modal.install.text3') }}</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                        {!! trans('repo.modal.install.text4', ['pkg' => '<span class="has-text-danger">notyf</span>']) !!}<br>
                        {!! trans('repo.modal.install.text5', ['pkg' => '<span class="has-text-danger">packages/</span>']) !!}<br>
                        {!! trans('repo.modal.install.text6', ['pkg' => '<span class="has-text-danger">assets/packages/notyf/</span>']) !!}<br>
                    </small>
                </p>
                <br>
                <button class="button is-info" id="modal-close-howto">{{ trans('repo.modal.okay') }}</button>
            </section>
        </div>
    </div>
@endsection

@section('add-package')
    <div id="modal-dialog-add-package" class="modal is-clipped">
        <div class="modal-background"></div>
        <div class="modal-content">
            <section class="modal-card-body">
                <p>{{ trans('repo.modal.share.text1') }}</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                        {!! trans('repo.modal.share.text2', [
                            'json' =>
                                '<a href="https://github.com/esyede/rakit/edit/master/repositories.json" target="_blank">repositories.json</a>',
                        ]) !!}<br>
                        {{ trans('repo.modal.share.text3') }}<br>
                        {!! trans('repo.modal.share.text4', [
                            'sub' => '<a href="https://github.com/esyede/rakit/discussions" target="_blank">Paket & library</a>',
                        ]) !!}<br>
                    </small>
                </p>
                <p>{{ trans('repo.modal.share.text5') }}</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                        {{ trans('repo.modal.share.text6') }}<br>
                        {{ trans('repo.modal.share.text7') }}<br>
                    </small>
                </p>
                <br>
                <button class="button is-success" id="modal-close-add-package">{{ trans('repo.modal.okay') }}</button>
            </section>
        </div>
    </div>
@endsection

@section('pages_title')
    <br>
    <h1 class="title">{{ trans('repo.hero.head') }}</h1>
    <p class="subtitle">{{ trans('repo.hero.text') }}</p>
    <div class="buttons is-block">
        <button id="show-modal-howto" class="button is-info">{{ trans('repo.hero.btn1') }}</button>
        <button id="show-modal-add-package" class="button is-success">{{ trans('repo.hero.btn2') }}</button>
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
                        <p class="menu-label">{{ trans('repo.side.cat') }}</p>
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
                                <a href="{{ url('repositories') }}">{{ trans('repo.content.all') }}
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
                                                        title="{{ trans('repo.content.maintained') }}">maintained</span>
                                                @else
                                                    <span class="button is-warning is-rounded is-small"
                                                        title="{{ trans('repo.content.unmaintained') }}">unmaintained</span>
                                                @endif
                                            </div>
                                            <p>
                                                <a class="is-size-4" title="{{ trans('repo.content.visit') }}"
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
                                                {{ trans('repo.content.compat') }}
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
                                    {{ trans('pagination.previous') }}</a>
                            @else
                                <a class="pagination-previous" href="#" disabled>&laquo;
                                    {{ trans('pagination.previous') }}</a>
                            @endif

                            @if ($current < $last)
                                <a class="pagination-next" href="?page={{ $current + 1 }}">{{ trans('pagination.next') }}
                                    &raquo;</a>
                            @else
                                <a class="pagination-next" href="#" disabled>{{ trans('pagination.next') }}
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
