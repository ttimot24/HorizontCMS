<?php 

if(!isset($_SESSION['id'])){
	return;
}

$user = new User();
$user = $user->get_instance(Session::get('id'));

?>


<div class='modal fade' id='lock_screen' role='dialog' onhide='lock_up();' aria-labelledby='myModalLabel' aria-hidden='true'>
		  <div class='modal-dialog modal-md'>
		    <div class='modal-content'>
		      <div class='modal-header '>
		      <h2 class='text-primary'><i class="fa fa-lock"></i> <?= $this->language['screen_locked'] ?></h2>
		        <!--<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		     	</br>-->
		      </div>
		      <div class='modal-body'>

		    	<center>
		    	 <img src='<?= $user->get_thumb() ?>' class='img-thumbnail' width='180'>



		    			<div class='form-group'>
						  <label for='usr'><?= $user->username ?></label>
						</div>

		    			<div class='form-group'>
						  <label for='pwd'><?= $this->language['password'] ?>:</label>
						  	<div class='input-group'>
						  		<input type='password' class='form-control' id='lock_pwd1' name='lock_pwd' style='width:300px;' required/>
							</div>
						</div>
	

		    	</center>

		    </div>
		    	      <div class='modal-footer'>
				        <button type='button' id='unlock_button' class='btn btn-primary' onclick='lock_up_screen();'><?= $this->language['unlock_screen'] ?></button>
				        <!--<a href='system/logout.php' type='button' class='btn btn-danger'>Log out</a>-->
				      </div>
		    </div>
		  </div>
		</div>