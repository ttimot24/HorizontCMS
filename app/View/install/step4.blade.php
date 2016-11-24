@extends('layout')

@section('content')
<div class='jumbotron'>
			  <div class='container'>
			  <h1><small>Installing HorizontCMS</small></h1>  



					<div class='progress'>
						  <div class='progress-bar progress-bar-striped active' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='min-width: 100em;'>
						    100%
						  </div>
					</div>
					<hr/>

  					<h2>Step 4: Finish</h2>
						</br>
						</br>

				@include('messages')

			<br><br>
			<a href='admin/login'><button type='button' class='btn btn-primary btn-md'>Finish & go to admin area <span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span></button></a>

</div>
</div>
@endsection