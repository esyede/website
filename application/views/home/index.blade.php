@layout('layouts.main')

@section('stats')
    <div class="band"{!! isset($news) ? ' id="news"' : '' !!}>
        <div class="shell shell--flush">
            <div class="cells cells--4">
                <div class="stat">
                    <span class="stat__num">5.4 &rarr; 8.x</span>
                    <span class="stat__label">PHP supported</span>
                </div>
                <div class="stat">
                    <span class="stat__num">< 1 MB</span>
                    <span class="stat__label">GZipped, docs included</span>
                </div>
                <div class="stat">
                    <span class="stat__num">0</span>
                    <span class="stat__label">Runtime dependencies</span>
                </div>
                <div class="stat">
                    <span class="stat__num">MIT</span>
                    <span class="stat__label">License</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('showcase')
    <div class="band">
        <div class="shell shell--flush">
            <div class="split">
                <div class="split__copy">
                    <span class="eyebrow">The whole request</span>
                    <h2>Four files, and the page is live</h2>
                    <p>Rakit keeps the path from URL to response short enough to read in one sitting. Point a route
                        at an action, pull the record, hand it to a view.</p>

                    <ul class="notes">
                        <li>
                            <b>Routes</b>
                            <span>Closures or controller actions, no problem.</span>
                        </li>
                        <li>
                            <b>Facile</b>
                            <span>Smart ORM with relationships, timestamps and soft deletes.</span>
                        </li>
                        <li>
                            <b>Blade</b>
                            <span>Layouts, sections and loops compiled, cached on first render.</span>
                        </li>
                    </ul>
                </div>

                <div class="split__demo">
                    <div class="panel" data-panel>
                        <div class="panel__tabs" role="tablist">
                            <button type="button" class="panel__tab is-current" role="tab" aria-selected="true"
                                aria-controls="snippet-routes" id="tab-routes">routes.php</button>
                            <button type="button" class="panel__tab" role="tab" aria-selected="false"
                                aria-controls="snippet-controller" id="tab-controller">posts.php</button>
                            <button type="button" class="panel__tab" role="tab" aria-selected="false"
                                aria-controls="snippet-model" id="tab-model">post.php</button>
                            <button type="button" class="panel__tab" role="tab" aria-selected="false"
                                aria-controls="snippet-view" id="tab-view">show.blade.php</button>
                        </div>

                        <pre class="panel__body is-current" id="snippet-routes" role="tabpanel" aria-labelledby="tab-routes"><code><span class="token comment">// application/routes.php</span>

<span class="token class-name">Route</span><span class="token punctuation">::</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string">'posts/(:num)'</span><span class="token punctuation">,</span> <span class="token string">'posts&#64;show'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token class-name">Route</span><span class="token punctuation">::</span><span class="token function">group</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token string">'before'</span> <span class="token operator">=&gt;</span> <span class="token string">'auth|csrf'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token class-name">Route</span><span class="token punctuation">::</span><span class="token function">post</span><span class="token punctuation">(</span><span class="token string">'posts'</span><span class="token punctuation">,</span> <span class="token string">'posts&#64;store'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Or answer inline, without a controller.</span>
<span class="token class-name">Route</span><span class="token punctuation">::</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string">'health'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token class-name">Response</span><span class="token punctuation">::</span><span class="token function">json</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token string">'ok'</span> <span class="token operator">=&gt;</span> <span class="token boolean">true</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

                        <pre class="panel__body" id="snippet-controller" role="tabpanel" aria-labelledby="tab-controller"><code><span class="token comment">// application/controllers/posts.php</span>

<span class="token keyword">class</span> <span class="token class-name">Posts_Controller</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">action_show</span><span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$post</span> <span class="token operator">=</span> <span class="token class-name">Post</span><span class="token punctuation">::</span><span class="token function">find_or_fail</span><span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token keyword">return</span> <span class="token class-name">View</span><span class="token punctuation">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token string">'posts.show'</span><span class="token punctuation">)</span>
            <span class="token operator">-&gt;</span><span class="token function">with</span><span class="token punctuation">(</span><span class="token string">'post'</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>

                        <pre class="panel__body" id="snippet-model" role="tabpanel" aria-labelledby="tab-model"><code><span class="token comment">// application/models/post.php</span>

<span class="token keyword">class</span> <span class="token class-name">Post</span> <span class="token keyword">extends</span> <span class="token class-name">Facile</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">static</span> <span class="token variable">$timestamps</span> <span class="token operator">=</span> <span class="token boolean">true</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">static</span> <span class="token variable">$fillable</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'title'</span><span class="token punctuation">,</span> <span class="token string">'body'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">author</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">belongs_to</span><span class="token punctuation">(</span><span class="token string">'User'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>

<span class="token variable">$posts</span> <span class="token operator">=</span> <span class="token class-name">Post</span><span class="token punctuation">::</span><span class="token function">where</span><span class="token punctuation">(</span><span class="token string">'published'</span><span class="token punctuation">,</span> <span class="token string">'='</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">order_by</span><span class="token punctuation">(</span><span class="token string">'created_at'</span><span class="token punctuation">,</span> <span class="token string">'desc'</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">take</span><span class="token punctuation">(</span><span class="token number">10</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

                        <pre class="panel__body" id="snippet-view" role="tabpanel" aria-labelledby="tab-view"><code><span class="token comment">&#123;&#123;-- application/views/posts/show.blade.php --&#125;&#125;</span>

<span class="token keyword">&#64;layout</span><span class="token punctuation">(</span><span class="token string">'layouts.main'</span><span class="token punctuation">)</span>

<span class="token keyword">&#64;section</span><span class="token punctuation">(</span><span class="token string">'content'</span><span class="token punctuation">)</span>
    <span class="token punctuation">&lt;</span><span class="token tag">article</span><span class="token punctuation">&gt;</span>
        <span class="token punctuation">&lt;</span><span class="token tag">h1</span><span class="token punctuation">&gt;</span>&#123;&#123; <span class="token variable">$post</span><span class="token operator">-&gt;</span>title &#125;&#125;<span class="token punctuation">&lt;/</span><span class="token tag">h1</span><span class="token punctuation">&gt;</span>
        <span class="token punctuation">&lt;</span><span class="token tag">p</span><span class="token punctuation">&gt;</span>By &#123;&#123; <span class="token variable">$post</span><span class="token operator">-&gt;</span>author<span class="token operator">-&gt;</span>name &#125;&#125;<span class="token punctuation">&lt;/</span><span class="token tag">p</span><span class="token punctuation">&gt;</span>

        <span class="token keyword">&#64;foreach</span> <span class="token punctuation">(</span><span class="token variable">$post</span><span class="token operator">-&gt;</span>comments <span class="token keyword">as</span> <span class="token variable">$comment</span><span class="token punctuation">)</span>
            <span class="token punctuation">&lt;</span><span class="token tag">p</span><span class="token punctuation">&gt;</span>&#123;&#123; <span class="token variable">$comment</span><span class="token operator">-&gt;</span>body &#125;&#125;<span class="token punctuation">&lt;/</span><span class="token tag">p</span><span class="token punctuation">&gt;</span>
        <span class="token keyword">&#64;endforeach</span>
    <span class="token punctuation">&lt;/</span><span class="token tag">article</span><span class="token punctuation">&gt;</span>
<span class="token keyword">&#64;endsection</span></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('features')
    <div class="band">
        <div class="shell">
            <div class="band__head">
                <span class="eyebrow">Why Rakit</span>
                <h2>A framework that stays out of your way</h2>
                <p>Everything below ships in the box. No package hunting, no build step.</p>
            </div>
        </div>
        <div class="shell shell--flush">
            <div class="cells cells--4">
                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path
                                d="M13 2 L13 6 11 7 8 4 4 8 7 11 6 13 2 13 2 19 6 19 7 21 4 24 8 28 11 25 13 26 13 30 19 30 19 26 21 25 24 28 28 24 25 21 26 19 30 19 30 13 26 13 25 11 28 8 24 4 21 7 19 6 19 2 Z" />
                            <circle cx="16" cy="16" r="4" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Strong foundation</h3>
                    <p class="cell__text">A mature code base and a sensible approach to writing web applications,
                        so you build on something solid instead of assembling it yourself.</p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path d="M18 13 L26 2 8 13 14 19 6 30 24 19 Z" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Get started quickly</h3>
                    <p class="cell__text">No convoluted installation procedure. Download and extract, or pull it in
                        with Composer &mdash; either way you are running in minutes.</p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path d="M10 9 L3 17 10 25 M22 9 L29 17 22 25 M18 7 L14 27" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Less writing</h3>
                    <p class="cell__text">Light, modular and fast. Rakit is easy enough to learn that onboarding
                        does not turn into a training budget.</p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path
                                d="M4 14 L4 30 28 30 28 14 M2 9 L2 14 30 14 30 9 2 9 Z M16 9 C 16 9 14 0 8 3 2 6 16 9 16 9 16 9 18 0 24 3 30 6 16 9 16 9" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Complete features</h3>
                    <p class="cell__text">Fast URL routing, multi-protocol cache drivers, a powerful database
                        abstraction layer and support for multilingual applications.</p>
                </article>
            </div>
        </div>
    </div>
@endsection

@section('stack')
    <div class="band">
        <div class="shell">
            <div class="band__bar">
                <div>
                    <span class="eyebrow">In the box</span>
                    <h2>Nothing left to install</h2>
                </div>
                <p>Every module below is part of the download. Pick the ones you need and ignore the rest.</p>
            </div>
        </div>
        <div class="shell shell--flush">
            <div class="stack">
                <section class="stack__group">
                    <h3>HTTP</h3>
                    <ul class="stack__list">
                        <li>Routing &amp; route groups</li>
                        <li>Middleware</li>
                        <li>Controllers &amp; RESTful actions</li>
                        <li>Requests &amp; input</li>
                        <li>Responses &amp; redirects</li>
                        <li>Sessions &amp; cookies</li>
                        <li>WebSocket server</li>
                    </ul>
                </section>

                <section class="stack__group">
                    <h3>Data</h3>
                    <ul class="stack__list">
                        <li>Facile ORM &amp; relationships</li>
                        <li>Magic query builder</li>
                        <li>Schema builder</li>
                        <li>Migrations</li>
                        <li>Pagination</li>
                        <li>Validation</li>
                        <li>Redis &amp; Memcached</li>
                    </ul>
                </section>

                <section class="stack__group">
                    <h3>Views</h3>
                    <ul class="stack__list">
                        <li>Blade templates</li>
                        <li>Layouts &amp; sections</li>
                        <li>Localization</li>
                        <li>Markdown</li>
                        <li>Asset &amp; URL helpers</li>
                        <li>Image manipulation</li>
                        <li>Messages &amp; error bags</li>
                    </ul>
                </section>

                <section class="stack__group">
                    <h3>Toolbox</h3>
                    <ul class="stack__list">
                        <li>Authentication &amp; hashing</li>
                        <li>Encryption, RSA &amp; JWT</li>
                        <li>Jobs &amp; queues</li>
                        <li>Cache drivers</li>
                        <li>Console commands</li>
                        <li>Hooks, events &amp; listeners</li>
                        <li>Mail, cURL &amp; storage</li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('quickstart')
    <div class="band">
        <div class="shell">
            <div class="band__head">
                <span class="eyebrow">Quick start</span>
                <h2>Running in three commands</h2>
                <p>Composer is optional &mdash; downloading the zip works exactly the same.</p>
            </div>
        </div>
        <div class="shell shell--flush">
            <div class="steps">
                <article class="step">
                    <span class="step__num">Create the project</span>
                    <h3>Pull in the framework</h3>
                    <p>Composer fetches Rakit and generates an application key for you.</p>
                    <div class="step__cmd">
                        <code><span class="prompt">$</span>composer create-project esyede/rakit</code>
                        <button type="button" class="copy" data-copy="composer create-project esyede/rakit"
                            aria-label="Copy this command">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="9" y="9" width="12" height="12" />
                                <path d="M5 15 L3 15 3 3 15 3 15 5" />
                            </svg>
                        </button>
                    </div>
                </article>

                <article class="step">
                    <span class="step__num">Set up the database</span>
                    <h3>Run the migrations</h3>
                    <p>Point <span class="hl">application/config/database.php</span> at your database, then build the
                        tables.</p>
                    <div class="step__cmd">
                        <code><span class="prompt">$</span>php rakit migrate</code>
                        <button type="button" class="copy" data-copy="php rakit migrate"
                            aria-label="Copy this command">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="9" y="9" width="12" height="12" />
                                <path d="M5 15 L3 15 3 3 15 3 15 5" />
                            </svg>
                        </button>
                    </div>
                </article>

                <article class="step">
                    <span class="step__num">Open it</span>
                    <h3>Serve the application</h3>
                    <p>The built-in server is enough for development. Deploy behind Apache or Nginx later.</p>
                    <div class="step__cmd">
                        <code><span class="prompt">$</span>php rakit serve</code>
                        <button type="button" class="copy" data-copy="php rakit serve"
                            aria-label="Copy this command">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="9" y="9" width="12" height="12" />
                                <path d="M5 15 L3 15 3 3 15 3 15 5" />
                            </svg>
                        </button>
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection

@section('involve')
    <div class="band">
        <div class="shell shell--flush">
            <div class="cells cells--3">
                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 64 64" aria-hidden="true">
                            <path stroke-width="0" fill="currentColor"
                                d="M32 0 C14 0 0 14 0 32 0 53 19 62 22 62 24 62 24 61 24 60 L24 55 C17 57 14 53 13 50 13 50 13 49 11 47 10 46 6 44 10 44 13 44 15 48 15 48 18 52 22 51 24 50 24 48 26 46 26 46 18 45 12 42 12 31 12 27 13 24 15 22 15 22 13 18 15 13 15 13 20 13 24 17 27 15 37 15 40 17 44 13 49 13 49 13 51 20 49 22 49 22 51 24 52 27 52 31 52 42 45 45 38 46 39 47 40 49 40 52 L40 60 C40 61 40 62 42 62 45 62 64 53 64 32 64 14 50 0 32 0 Z" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Read the source</h3>
                    <p class="cell__text">The whole framework lives in one repository. Browse it, fork it, or open an
                        issue on
                        <a href="https://github.com/esyede/rakit" target="_blank">Github</a>.
                    </p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path d="M2 4 L30 4 30 22 16 22 8 29 8 22 2 22 Z" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Ask a question</h3>
                    <p class="cell__text">Stuck on setup, or want to compare notes? Other developers are on the
                        <a href="https://github.com/esyede/rakit/discussions" target="_blank">discussion forum</a>.
                    </p>
                </article>

                <article class="cell">
                    <span class="cell__icon">
                        <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                            <path d="M6 2 L6 30 M6 6 L26 6 20 12 26 18 6 18" />
                        </svg>
                    </span>
                    <h3 class="cell__title">Send a patch</h3>
                    <p class="cell__text">Bug fixes, docs and translations are all welcome. Start with the
                        <a href="https://github.com/esyede/rakit/blob/main/.github/CONTRIBUTING.md"
                            target="_blank">contributing guide</a>.
                    </p>
                </article>
            </div>
        </div>
    </div>
@endsection

@section('packages')
    {{-- The hatched band dsgn.html sets between sections; used once here, to
         mark the hand-off from the tour to the closing call to action. --}}
    <div class="sep"></div>

    <div class="band">
        <div class="cta">
            <span class="eyebrow">Package repository</span>
            <h2>Download and share your package</h2>
            <p>{{ $package_count }} packages across {{ $category_count }} categories, built and maintained by the
                community.</p>

            <div class="chips">
                @foreach ($featured as $item)
                    <a class="chip{{ $item['maintained'] ? '' : ' chip--muted' }}"
                        href="{{ url('repositories/' . System\Str::slug($item['category'])) }}">
                        <span class="chip__dot"></span>{{ $item['name'] }}
                    </a>
                @endforeach
            </div>

            <a class="btn btn--primary" href="{{ url('repositories') }}">
                <svg class="btn__icon" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2" aria-hidden="true">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M19 19 L28 28" />
                </svg>
                Browse all packages
            </a>
        </div>
    </div>
@endsection

@section('main')
    @yield('stats')
    @yield('showcase')
    @yield('features')
    @yield('stack')
    @yield('quickstart')
    @yield('involve')
    @yield('packages')
@endsection
