

<div class="col-md-12 well">

		<?php if(\Auth::check()): ?>
			<center>
			<h4>Welcome <b><?= \Auth::user()->name; ?></b>!</h4><br>
			<p><img style="height:150px;width:150px;object-fit:cover;border:2px solid;" class="img-circle" src="<?= \Auth::user()->getThumb(); ?>"></p>
			<br>
			<a href="logout" class='btn btn-block btn-lg btn-primary'>Logout</a>
			</center>
		<?php else: ?>
		<center><h3>Sign in</h3></center><br>
		<form action="authenticate" method="POST">
		<div class="col-md-12">
			<?= csrf_field(); ?>
 			<input type='text' class='form-control' id='username' name='username' placeholder="username" required><br>
			<input type='password' class='form-control' id='password' name='password' placeholder="password" required>
			<br>
			<button type='submit' class='btn btn-block btn-lg btn-primary'>Login</button>
		</div>
		</form>
	<?php endif; ?>

</div>



<div class="col-md-12 well">
	<h4>Widget 2</h4>
	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
</div>











