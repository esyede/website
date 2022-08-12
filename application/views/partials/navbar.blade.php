<nav id="navbar" class="navbar is-fixed-top has-shadow" role="navigation" aria-label="main navigation">
	<div class="container">
		<div class="navbar-brand">
			<a class="navbar-item" href="{{ URL::home() }}"><b class="is-uppercase">RAKIT</b></a>
			<div id="navbarBurger" class="navbar-burger burger" data-target="navMenuMore">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		<div id="navMenuMore" class="navbar-menu">
			<div class="navbar-end">
				<a class="navbar-item" href="{{ URL::home() }}">{{ __('home.navbar.one') }}</a>
				<a class="navbar-item" href="{{ url('docs/'.config('application.language')) }}">{{ __('home.navbar.two') }}</a>
				<a class="navbar-item" href="{{ url('api/'.RAKIT_VERSION.'/index.html') }}" target="_blank">{{ __('home.navbar.three') }}</a>
				<a class="navbar-item" href="{{ url('repositories') }}">{{ __('home.navbar.four') }}</a>
				<a class="navbar-item" href="{{ url('forum') }}" target="_blank">{{ __('home.navbar.five') }}</a>
				<a class="navbar-item" href="https://github.com/esyede/rakit" target="_blank">{{ __('home.navbar.six') }}</a>
			</div>
		</div>
	</div>
</nav>
