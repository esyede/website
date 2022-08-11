<nav id="navbar" class="navbar is-fixed-top has-shadow" role="navigation" aria-label="main navigation">
	<div class="container">
		<div class="navbar-brand">
			<a class="navbar-item" href="{{ URL::home() }}"><b class="is-uppercase">{{ $brand }}</b></a>
			<div id="navbarBurger" class="navbar-burger burger" data-target="navMenuMore">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		<div id="navMenuMore" class="navbar-menu">
			<div class="navbar-end">
				<a class="navbar-item" href="{{ URL::home() }}">Rumah</a>
				<a class="navbar-item" href="{{ url('docs') }}">Dokumentasi</a>
				<a class="navbar-item" href="{{ url('api/'.RAKIT_VERSION.'/index.html') }}" target="_blank">API</a>
				<a class="navbar-item" href="{{ url('repositories') }}">Repositori</a>
				<a class="navbar-item" href="{{ url('forum') }}" target="_blank">Forum</a>
				<a class="navbar-item" href="https://github.com/esyede/rakit" target="_blank">Github</a>
			</div>
		</div>
	</div>
</nav>
