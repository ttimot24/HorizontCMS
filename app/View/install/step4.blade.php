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

				@if(!session()->has('error'))
				<br>
				<p>
					<h4>Don't forget to set up cron for sheduled jobs:</h4>
					<pre style='padding:20px;text-align:center;font-weight:bolder;'>* * * * * php {{base_path('artisan')}} schedule:run >> /dev/null 2>&1</pre>
				</p>
				@endif

			@if(!session()->has('error'))
			<br><br>
				<a href="{{admin_link('login-login')}}"><button type='button' class='btn btn-primary btn-md animated pulse delay-3s'>Finish & go to admin area <span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span></button></a>
			@else
				<a href="admin/install/step3"><button type='button' class='btn btn-primary btn-md'>Retry <span class='glyphicon glyphicon glyphicon-repeat' aria-hidden='true'></span></button></a>
			@endif
</div>
</div>
@endsection