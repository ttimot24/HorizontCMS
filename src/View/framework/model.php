<title>Generate Model - HorizontMVC</title>

<div class='jumbotron' style='margin-top:-1%;background-color:#e0b50b;'>
	<h1 class='container'>
		<span class="glyphicon glyphicon-leaf" aria-hidden="true" style='color:green;'></span> <b><i>HorizontMVC Framework</i></b>
	</h1>
</div>
<hr/>
<div class='container'>
	<h1>
		Generate Model
	</h1>
	<section class='container'>
		
	<form action='admin/framework/generate/model' method='POST'>	
		 <div class='form-group pull-left col-xs-12 col-md-6'>
			 <label for='title'>Select table</label>
			 	<select class='form-control' name='model_table'>
			 	<?php foreach($data as $table){
			 		echo "<option >".$table."</option>";
			 	} ?>
			 	</select>
		</div>

		<div class='form-group pull-left col-xs-12 col-md-6'>
			 <label for='title'>Model path</label>
			      <input type='text' class='form-control' id='title' name='model_path' value='model/'></br>
		</div>

		<div class='form-group pull-left col-xs-12 col-md-12'>
			<center><input type='submit' class='btn btn-primary btn-lg' value='Generate'></center>
		</div>


	</form>
	</section>
</div>
<hr/>