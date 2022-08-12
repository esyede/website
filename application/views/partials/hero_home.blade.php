<section class="hero hero is-medium is-info hero-section py-5" id="hero-section">
	<div class="hero-body">
		<div id="particles-js" class="particles-js"></div>
		<div class="container">
			<h1 class="title has-text-centered is-block is-uppercase">RAKIT</h1>
			<h2 class="subtitle has-text-centered is-block">{{ __('home.hero.slogan') }}</h2>
			<div class="has-text-centered">
				<a href="{{ url('download') }}" class="button is-success is-inverted is-outlined">{{ __('home.hero.btn1') }}</a>
				<a href="{{ url('docs/'.config('application.language')) }}" class="button is-link is-inverted is-outlined">{{ __('home.hero.btn2') }}</a>
				<br>
				<small>{{ __('home.hero.text') }} {{ RAKIT_VERSION }}</small>
			</div>
		</div>
	</div>
</section>
