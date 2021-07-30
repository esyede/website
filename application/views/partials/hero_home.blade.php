<section class="hero hero is-medium is-info hero-section py-5" id="hero-section">
	<div class="hero-body">
		<div id="particles-js" class="particles-js"></div>
		<div class="container">
			<h1 class="title has-text-centered is-block is-uppercase">{{ $brand }}</h1>
			<h2 class="subtitle has-text-centered is-block">{{ $tagline }}</h2>
			<div class="has-text-centered">
				<a href="{{ url('download') }}" class="button is-success is-inverted is-outlined">Download</a>
				<a href="{{ url('docs') }}" class="button is-link is-inverted is-outlined">Dokumentasi</a>
				<br>
				<small>Rilis terbaru: {{ RAKIT_VERSION }}</small>
			</div>
		</div>
	</div>
</section>
