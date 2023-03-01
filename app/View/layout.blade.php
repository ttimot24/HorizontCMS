<!DOCTYPE html>
<html>
<head>
	<base href="{{ config('app.url') }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	
	<title>{{ $title }} - {{ Config::get('app.name') }}</title>
	<link rel="shortcut icon" type="image/png" href="{{ asset('resources/images/icons/favicon16.png')}}"/>


	@foreach ($css as $each_css)
    	<link rel="stylesheet" type="text/css" href="{{asset($each_css)}}">
	@endforeach

</head>
<body @if(Auth::user()) style="padding-top: 5rem;" @endif>

	<div id="hcms">

		@if (!Auth::guest())
			@include('navbar')
			@include('messages')
			@include('lock_screen')
		@endif

		

		@yield('content')


		<footer id='footer'>
			<div class='container'>
				<div class="row py-5 px-3">
					<div class='col-md-6'>
						<p class='text-muted credit mb-0'>
						{{ config('app.name') }} &copy 2015 - {{ date('Y') }} <a href='http://www.twitter.com/timottarjani'>Timot Tarjani</a> 
						&nbsp&nbsp<a href='https://github.com/ttimot24/HorizontCMS'><i style='font-size: 1.2em' class="fa fa-github" aria-hidden="true"></i></a>
						</p>
					</div>
					<div class='col-md-6 text-right text-end'>
						Version: {{config('horizontcms.version')}}
					</div>
				</div>
			</div>	
		</footer>
	</div>

	@foreach ($js as $each_js)
    	<script type="text/javascript" src="{{asset($each_js)}}"></script>
	@endforeach

	@foreach ($jsplugins as $each_js)
    	<script type="text/javascript" src="{{asset($each_js)}}"></script>
	@endforeach

</body>
</html>