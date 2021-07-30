@layout('layouts.main')

@section('howto')
    <div id="modal-dialog-howto" class="modal is-clipped">
        <div class="modal-background"></div>
        <div class="modal-content">
            <section class="modal-card-body">
                <p>Contoh instalasi paket bernama <i class="has-text-success">themable</i>:</p>
                <p><pre><code>php rakit package:install themable</code></pre></p>
                <br>
                <p>Instalasi manual:</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                    1. Unduh paket <span class="has-text-danger">themable</span> tersebut<br>
                    2. Ekstrak ke folder <span class="has-text-danger">packages/</span><br>
                    3. Jika paket tersebut memiliki aset, salin asetnya ke <span class="has-text-danger">assets/packages/themable/</span><br>
                    </small>
                </p>
                <br>
                <button class="button is-info" id="modal-close-howto">Oke, Mengerti</button>
            </section>
        </div>
    </div>
@endsection

@section('add-package')
    <div id="modal-dialog-add-package" class="modal is-clipped">
        <div class="modal-background"></div>
        <div class="modal-content">
            <section class="modal-card-body">
                <p>Cara berbagi paket:</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                    1. Login ke github dan edit file <a href="https://github.com/esyede/rakit/edit/master/repositories.json" target="_blank">repositories.json</a> untuk menambahkan data paket anda.<br>
                    2. Kirim pull request berupa perubahan yang anda buat tersebut.<br>
                    3. Buat thread baru di subforum <a href="{{ url('forum/forum6-paket-library.html') }}" target="_blank">Paket & library</a> sesuai nama paket anda dan jelaskan detailnya.<br>
                    </small>
                </p>
                <p>Jika rilis versi baru:</p>
                <p class="notification has-text-left is-unselectable">
                    <small>
                    1. Ulangi langkah "Cara berbagi paket" diatas.<br>
                    2. Edit postingan pertama di thread anda dan tambahkan detail versi baru anda.<br>
                    </small>
                </p>
                <br>
                <button class="button is-success" id="modal-close-add-package">Oke, Mengerti</button>
            </section>
        </div>
    </div>
@endsection

@section('pages_title')
    <br>
    <h1 class="title">Repositori Paket</h1>
    <p class="subtitle">Download dan bagikan paket anda bersama pengembang lain</p>
    <div class="buttons is-block">
        <button id="show-modal-howto" class="button is-info">Cara Install?</button>
        <button id="show-modal-add-package" class="button is-success">Bagikan Paket</button>
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
                        <p class="menu-label">Kategori</p>
                        <ul class="menu-list">
                            @foreach ($categories as $category)
                            <li>
                                <a href="{{ url('repositories/'.Str::slug($category['name'])) }}">
                                    {{ Str::title($category['name']) }}
                                    <span class="tag is-info is-light is-rounded">
                                        {{ $category['count'] }}
                                    </span>
                                </a>
                            </li>
                            @endforeach
                            <li>
                                <a href="{{ url('repositories') }}">Semua
                                    <span class="tag is-info is-light is-rounded">
                                        {{ $totalcount }}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </aside>
                </div>
                <div class="column is-9-desktop is-9-tablet">
                    <div class="container">
                        <p class="menu-label is-size-6">{{ $catname }}</p>
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
                                            <span class="button is-success is-rounded is-small" title="Paket ini masih dimaintain oleh pembuatnya">maintained</span>
                                        @else
                                            <span class="button is-warning is-rounded is-small" title="Paket ini sudah tidak dimaintain oleh pembuatnya">unmaintained</span>
                                        @endif
                                    </div>
                                    <p>
                                        <a class="is-size-4" title="Kunjungi repositori milik paket ini" href="{{ $packages[$i]['repository'] }}"  target="_blank">{{ $packages[$i]['name'] }}</a>
                                        <br>
                                        {!! nl2br($packages[$i]['description']) !!}
                                    </p>
                                    <br>
                                    <div class="is-pulled-left">
                                        <a class="tag is-small is-primary" href="{{ url('repositories/'.Str::slug($packages[$i]['category'])) }}" title="Kategori: {{ $packages[$i]['category'] }}">{{ Str::title($packages[$i]['category']) }}</a>
                                    </div>
                                    <span class="is-pulled-right is-size-7">
                                        Kompatibel: {{ implode(', ', array_keys($packages[$i]['compatibilities'])) }}
                                    </span>
                                  </div>
                                </div>
                              </article>
                            </div>
                        @endfor

                        <nav class="pagination is-rounded" role="navigation">
                            @if ($currpage > 1)
                                <a class="pagination-previous" href="?page={{ ($currpage - 1) }}">&laquo; Sebelumnya</a>
                            @else
                                <a class="pagination-previous" href="#" disabled>&laquo; Sebelumnya</a>
                            @endif

                            @if ($currpage < $totalpage)
                                <a class="pagination-next" href="?page={{ ($currpage + 1) }}">Selanjutnya &raquo;</a>
                            @else
                                <a class="pagination-next" href="#" disabled>Selanjutnya &raquo;</a>
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
