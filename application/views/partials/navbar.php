<?php if (isset($announcement)):?>
<div class="announcement">
  <div class="container">
	<div class="announcement-body">
	  <p><?php echo $announcement;?></p>
	</div>
  </div>
</div>
<?php endif;?>

<nav id="navbar" class="navbar is-fixed-top has-shadow" role="navigation" aria-label="main navigation">
	<div class="container">
		<div class="navbar-brand">
			<a class="navbar-item" href="<?php echo URL::home();?>"><b style="text-transform:uppercase;"><?php echo e($brand);?></b></a>
			<div id="navbarBurger" class="navbar-burger burger" data-target="navMenuMore">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		<div id="navMenuMore" class="navbar-menu">
			<div class="navbar-end">
				<a class="navbar-item" href="<?php echo URL::home();?>">Rumah</a>
				<a class="navbar-item" href="<?php echo url('docs');?>">Dokumentasi</a>
				<a class="navbar-item" href="<?php echo url('api');?>" target="_blank">API</a>
				<a class="navbar-item" href="<?php echo url('repositories');?>">Repositori</a>
				<a class="navbar-item" href="<?php echo url('forum');?>">Forum</a>
				<a class="navbar-item" href="https://github.com/esyede/rakit" target="_blank">Github</a>
			</div>
		</div>
	</div>
</nav>
