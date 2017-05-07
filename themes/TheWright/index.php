<header>
	<section class="jumbotron" style="<?= Website::$_HEADER_IMAGES->count()>0 ? "background-image:url(storage/images/header_images/".Website::$_HEADER_IMAGES->first()->image.");" : ""; ?> background-size:cover;text-align:center;padding:125px 0px 125px 0px;margin:0px;">
		<center>
		<div style="padding:10px 20px 10px 20px;width:450px;background-color:rgba(0,0,0,0.8);color:white;">
			<h2><?= Settings::get('site_name') ?></h2>
			<hr style="width:50%;">
			<h4><?= Website::$_SETTINGS->slogan; ?></h4>
		</div>
		</center>
	</section>
</header>

<?php Website::require_theme_file("sitelinks.php"); ?>

<section class="container">
<div class="row">

<div class="col-md-8">

<?php Website::handle_routing(); ?>

</div>

<div class="col-md-4">
<?php Website::require_theme_file("sidebar.php"); ?>
</div>
</div>
</section>