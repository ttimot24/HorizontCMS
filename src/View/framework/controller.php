<title>Generate Model - HorizontMVC</title>

<div class='jumbotron' style='margin-top:-2%;background-color:#e0b50b;'>
	<h1 class='container'>
		<span class="glyphicon glyphicon-leaf" aria-hidden="true" style='color:green;'></span> <b><i>HorizontMVC Framework</i></b>
	</h1>
</div>
<hr/>
<div class='container'>
	<h1>
		Generate Controller
	</h1>
	<section class='container'>
		
	<form action='framework/generate/contoller' method='POST'>	
		 <div class='form-group pull-left col-xs-12 col-md-6'>
			 <label for='title'>Controller name</label>
			 	<input type='text' class='form-control' name='controller_name' />
		</div>

		<div class='form-group pull-left col-xs-12 col-md-6'>
			 <label for='title'>Model path</label>
			      <input type='text' class='form-control' id='title' name='controller_path' value='controller/'></br>
		</div>

		<div class='form-group pull-left col-xs-12 col-md-12'>
			<center><input type='submit' class='btn btn-primary btn-lg' value='Generate'></center>
		</div>


	</form>
	</section>
</div>
<hr/>