<!DOCTYPE html>
<html lang="id">
	<?php echo view('partials.header')->with(get_defined_vars())->render();?>
	<body class="has-background-white">
		<?php echo view('partials.navbar')->with(get_defined_vars())->render();?>
		<?php if (Str::starts_with($page, 'Home')):?>
			<?php echo view('partials.hero_home')->with(get_defined_vars())->render();?>
		<?php else:?>
			<?php echo view('partials.hero_pages')->with(get_defined_vars())->render();?>
		<?php endif;?>
		<?php echo yield_content('main');?>
		<div class="divider is-white"></div>
		<div class="divider is-white"></div>
		<div class="divider is-white"></div>
		<?php echo view('partials.footer')->with(get_defined_vars())->render();?>
	</body>
</html>
