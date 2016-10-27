@extends('layout');

@section('content')
<div class='container'>
			  <div class='jumbotron'>
			  <h1><small>Installing HorizontCMS</small></h1>   




<div class='progress'>
			<div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='min-width: 35em;'>
						    40%
						  </div>
					</div>
					<hr/>


  		<h2>Step 2: Database</h2>
					</br>
					

		<?php 
			//require(VIEW_DIR."default/messages.php");
		?>

		</br>

		<form action='admin/install/checkconnection' method='POST'>


			<div class='container'>

				 <div class='form-group'>
			      <label class='control-label col-md-2' for='server'>Database Driver:</label>
			      <div class='col-md-5'>
			      	<select  class='form-control' name='db_driver'>
			      <?php
			      	foreach($data['db_drivers'] as $driver){
			      		echo "<option value='".$driver."'>".ucfirst($driver)."</option>";
			      	}
			      ?>
			      	</select>          
			      
			      </div>
			    </div>
			    </br></br>
			  
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='server'>Server:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='server' name='server' value='<?= isset($data['session']['server'])? $data['session']['server'] : "localhost" ; ?>' required>
			      </div>
			    </div>
			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='username'>Username:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='username' name='username' placeholder='username' value='<?= @$data['session']['install_username'] ?>' required>
			      </div>
			    </div>

			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='pwd'>Password:</label>
			      <div class='col-sm-5'>          
			        <input type='password' class='form-control' id='pwd' name='password' placeholder='password' value='<?= @$data['session']['install_password'] ?>' required>
			      </div>
			    </div>

			  	</br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='data'>Create database:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='data' name='database' placeholder='database name' value='<?= @$data['session']['database'] ?>' required>
			      </div>
			    </div>

			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='prefix'>Table prefix:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='prefix' name='prefix' placeholder='prefix' value='<?= @$data['session']['prefix'] ?>'>
			      </div>
			    </div>

			</div>
			</br>
			</br>
					<a href='admin/install/step1'><button type='button' class='btn btn-default btn-md'><span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span> Previous</button></a>
					<button type='submit' class='btn btn-primary btn-md'>&nbsp&nbspNext&nbsp&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp&nbsp</button>
					
						
		</form>

</div>
  	</div>
@endsection