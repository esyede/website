<!DOCTYPE html>
<html lang="id">
	@include('partials.header')
	<body class="has-background-white">
		@include('partials.navbar')
		@if (Str::starts_with($page, 'Home'))
			@include('partials.hero_home')
		@else
			@include('partials.hero_pages')
		@endif
		@yield('main')
		<div class="divider is-white"></div>
		<div class="divider is-white"></div>
		<div class="divider is-white"></div>
		@include('partials.footer')
	</body>
</html>
