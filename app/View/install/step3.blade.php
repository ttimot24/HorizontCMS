@extends('layout')

@section('content')
<div class='jumbotron'>
			  <div class='container'>
			  <h1><small>Installing HorizontCMS</small></h1>  


<div class='progress'>
			<div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='80' aria-valuemin='0' aria-valuemax='100' style='min-width: 80em;'>
						    80%
						  </div>
					</div>
					<hr/>


  		<h2>Step 3: Administrator</h2>
					</br>

		@include('messages')

				</br>

				<form action='admin/install/migrate' method='POST'>



				<div class='container'>

				<div class='form-group'>
			      <label class='control-label col-sm-3' for='username'>Create username:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='username' name='ad_username' placeholder='username' value='<?= @$data['session']['ad_username'] ?>' required>
			      </div>
			    </div>

			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='pwd'>Create password:</label>
			      <div class='col-sm-5'>          
			        <input type='password' class='form-control' id='pwd' name='ad_password' placeholder='password' value='<?= @$data['session']['ad_password'] ?>' required>
			      </div>
			    </div>
			    

			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='em'>Email:</label>
			      <div class='col-sm-5'>          
			        <input type='email' class='form-control' id='em' name='ad_email' placeholder='email' value='<?= @$data['session']['ad_email'] ?>' required>
			      </div>
			    </div>
			    </div>

			   	 </br>
					</br>
					<a href='admin/install/step2'><button type='button' class='btn btn-default btn-md'><span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span> Previous</button></a>
					<button type='submit' class='btn btn-primary btn-md'>&nbsp&nbspNext&nbsp&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp&nbsp</button>
					
			    </div>
			    </form>

</div>
</div>
@endsection