	<div class='jumbotron' style='margin-top: -4.65%;'>
	<div class='container'>
   
  	<img src='<?= $data['admin_logo']; ?>' width='100' class='pull-left'>

		<h1>HorizontCMS</h1>
		<p style='margin-left:15%;'><q><i>Closer to the web</i></q></p>
		</div></div>

	<div class='container'>

<?php require(VIEW_DIR.'default/messages.php') ?>

	<form action='admin/login/authenticate' role='form' method='POST' >
			<div class='col-xs-12 col-md-3 pull-left'>  
			  <div class='form-group'>
			    <label for='text'><?= $this->language['username'] ?>:</label>
			    <input type='text' class='form-control' id='username' name='username' placeholder='<?= $this->language['enter_username'] ?>' required>
			  </div>
			  <div class='form-group'>
			    <label for='pwd'><?= $this->language['password'] ?>:</label>
			    <input type='password' class='form-control' id='pwd' name='password' placeholder='<?= $this->language['enter_password'] ?>' required>
			  </div>
			 
			  <div class='checkbox'>
			    <label><input type='checkbox'> <?= $this->language['remember_me'] ?></label>
			  </div>
			  <input type='submit' name='submit_login' class='btn btn-default' value='<?= $this->language['login'] ?>'>

			</div>
	</form>

 

	<?php include(VIEW_DIR."default/showcase.php") ?>





	</div>

	</br>