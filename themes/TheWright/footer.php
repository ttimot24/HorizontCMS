<footer class="col-md-12" style="background-color:#222;min-height:75px;color:white;padding:20px;">
<div class="container">
<div class="row">
	<div class="col-md-4">
	<p>&copy 2016 The Wright Theme</p>
	</div>
	<div class="col-md-4">
	</div>
	<div class="col-md-4 text-right" style='font-size:26px;'>
	 	<a href="<?= SocialLink::getLinkTo('facebook') ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>&nbsp&nbsp&nbsp
	 	<a href="<?= SocialLink::getLinkTo('google') ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
	</div>
</div>
</div>
</footer>


<style>
.dropdown:hover .dropdown-menu {
    display: block;
  /*  margin-top: 0;*/
 }
</style>


	<?php Website::jsPlugins(); ?>
</body>
</html>