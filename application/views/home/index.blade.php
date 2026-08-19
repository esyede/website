@layout('layouts.main')

@section('features')
    <!-- features -->
    <div class="divider is-white"></div>
    <section class="section"{!! isset($news) ? ' id="news"' : '' !!}>
        <div class="tile is-ancestor">
            <div class="tile is-vertical is-8">
                <div class="tile">
                    <div class="tile is-parent is-vertical">
                        <article class="tile is-child notification">
                            <p class="subtitle">
                                <span class="icon is-small">
                                    <svg id="i-settings" xmlns="http://www.w3.org/2000/svg" viewBox="0 -13 32 32"
                                        width="32" height="32" fill="none" stroke="currentcolor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5">
                                        <path
                                            d="M13 2 L13 6 11 7 8 4 4 8 7 11 6 13 2 13 2 19 6 19 7 21 4 24 8 28 11 25 13 26 13 30 19 30 19 26 21 25 24 28 28 24 25 21 26 19 30 19 30 13 26 13 25 11 28 8 24 4 21 7 19 6 19 2 Z" />
                                        <circle cx="16" cy="16" r="4" />
                                    </svg>
                                </span>
                                <span>Strong Foundation</span>
                            </p>
                            <p>Take advantage of the rakit's built-in features. Develop truly great applications. Rakit gives you a solid foundation, a mature code base, and a sensible approach to writing web applications.</p>
                        </article>
                        <article class="tile is-child notification">
                            <p class="subtitle">
                                <span class="icon is-small">
                                    <svg id="i-lightning" xmlns="http://www.w3.org/2000/svg" viewBox="0 -13 32 32"
                                        width="32" height="32" fill="none" stroke="currentcolor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5">
                                        <path d="M18 13 L26 2 8 13 14 19 6 30 24 19 Z" />
                                    </svg>
                                </span>
                                <span>Get Started Quickly</span>
                            </p>
                            <p>Whether you are a beginner or a professional PHP programmer, rakit will get you up and running in less time. There is no convoluted installation procedure. Just download and extract.</p>
                        </article>
                    </div>
                    <div class="tile is-parent is-vertical">
                        <article class="tile is-child notification">
                            <p class="subtitle">
                                <span class="icon is-small">
                                    <svg id="i-code" xmlns="http://www.w3.org/2000/svg" viewBox="0 -13 32 32"
                                        width="32" height="32" fill="none" stroke="currentcolor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5">
                                        <path d="M10 9 L3 17 10 25 M22 9 L29 17 22 25 M18 7 L14 27" />
                                    </svg>
                                </span>
                                <span>Less Writing</span>
                            </p>
                            <p>Speed up your development process. rakit is very light, easy to use, modular and fast. Most importantly, rakit doesn't get in your way. Rakit are so easy to learn that you can save money on training expenses.</p>
                        </article>
                        <article class="tile is-child notification">
                            <p class="subtitle">
                                <span class="icon is-small">
                                    <svg id="i-gift" xmlns="http://www.w3.org/2000/svg" viewBox="0 -13 32 32"
                                        width="32" height="32" fill="none" stroke="currentcolor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5">
                                        <path
                                            d="M4 14 L4 30 28 30 28 14 M2 9 L2 14 30 14 30 9 2 9 Z M16 9 C 16 9 14 0 8 3 2 6 16 9 16 9 16 9 18 0 24 3 30 6 16 9 16 9" />
                                    </svg>
                                </span>
                                <span>Complete Features</span>
                            </p>
                            <p>Rakit is an easy-to-use web development tool, it comes with fast URL routing, multi-protocol cache driver, powerful database abstraction layer, and support for multilingual applications.</p>
                        </article>
                    </div>
                </div>
            </div>
            <div class="tile is-parent">
                <article class="tile is-child notification">
                    <div class="content">
                        <p class="subtitle">
                            <span class="icon is-small">
                                <svg id="i-flag" xmlns="http://www.w3.org/2000/svg" viewBox="0 -13 32 32" width="32"
                                    height="32" fill="none" stroke="currentcolor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="3">
                                    <path d="M6 2 L6 30 M6 6 L26 6 20 12 26 18 6 18" />
                                </svg>
                            </span>
                            <span>Let's Start!</span>
                        </p>
                        <p>It's time to start developing web applications the easy way!</p>
                        <p>
                            <a href="{{ url('download') }}" class="button is-success">
                                Download {{ RAKIT_VERSION }}
                            </a>
                            <br>
                            <br>
                        </p>
                        <p class="subtitle">
                            <span class="icon is-small">
                                <svg id="i-github" xmlns="http://www.w3.org/2000/svg" viewBox="0 -30 64 64" width="32"
                                    height="32">
                                    <path stroke-width="0" fill="currentColor"
                                        d="M32 0 C14 0 0 14 0 32 0 53 19 62 22 62 24 62 24 61 24 60 L24 55 C17 57 14 53 13 50 13 50 13 49 11 47 10 46 6 44 10 44 13 44 15 48 15 48 18 52 22 51 24 50 24 48 26 46 26 46 18 45 12 42 12 31 12 27 13 24 15 22 15 22 13 18 15 13 15 13 20 13 24 17 27 15 37 15 40 17 44 13 49 13 49 13 51 20 49 22 49 22 51 24 52 27 52 31 52 42 45 45 38 46 39 47 40 49 40 52 L40 60 C40 61 40 62 42 62 45 62 64 53 64 32 64 14 50 0 32 0 Z" />
                                </svg>
                            </span>
                            <span>Repositories</span>
                        </p>
                        <p>Join us on <a href="https://github.com/esyede/rakit">Github</a> to make rakit even better.</p>
                        <p class="subtitle">
                            <span class="icon is-small">
                                <svg id="i-msg" xmlns="http://www.w3.org/2000/svg" viewBox="0 -13 32 32" width="32"
                                    height="32" fill="none" stroke="currentcolor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="3">
                                    <path d="M2 4 L30 4 30 22 16 22 8 29 8 22 2 22 Z" />
                                </svg>
                            </span>
                            <span>Forum</span>
                        </p>
                        <p>Having trouble getting started? Or want to share your thoughts? Let's talk with
                            other developers at
                            <a href="https://github.com/esyede/rakit/discussions" target="_blank">Discussion Forum</a>
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <!-- /features -->
@endsection

@section('packages')
    <!-- packages -->
    <div class="divider is-white"></div>
    <div class="container section has-text-centered has-background-light">
        <div class="columns">
            <div class="column is-half is-offset-one-quarter">
                <h1 class="title is-2">Package Repository</h1>
                <p>Download and share your package with other developers</p>
                <br>
                <div class="buttons is-block">
                    <a href="{{ url('repositories') }}" class="button is-success">
                        <span class="icon is-small">
                            <svg id="i-search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32"
                                height="32" fill="none" stroke="currentcolor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M19 19 L28 28" />
                            </svg>
                        </span>
                        <span>Find a Package..</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /packages -->
@endsection

@section('main')
    @yield('features')
    <div class="divider is-white"></div>
    <div class="divider is-white"></div>
    @yield('packages')
@endsection
