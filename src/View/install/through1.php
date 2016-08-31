<div class='jumbotron' style='margin-top:-4.7%;'>
		<h1 class='container'>HorizontCMS<small> Spread - Through install</small></h1>
</div>


<div class='container'>

<h1>Database details</h1>

<form role='form' method='POST' action='admin/install/spread'>

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
			        <input type='text' class='form-control' id='server' name='server' value='localhost' required>
			      </div>
			    </div>
			    <br><br><br>

			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='username'>Username:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='install_username' name='username' placeholder='username' value='' required>
			      </div>
			    </div>
			    <br><br>

			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='pwd'>Password:</label>
			      <div class='col-sm-5'>          
			        <input type='password' class='form-control' id='pwd' name='install_password' placeholder='password' value='' required>
			      </div>
			    </div>
			    <br><br>

			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='data'>Create database:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='data' name='database' placeholder='database name' value='' required>
			      </div>
			    </div>
			    <br><br>
			    <center><button class='btn btn-primary' type='submit'>Finish through install</button></center>

</form>

<br><br>
</div>