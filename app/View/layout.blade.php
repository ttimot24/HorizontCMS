<!DOCTYPE html>
<html>
<head>
	<base href="{{ Config::get('app.url') }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	
	<title>{{ $title }} - {{ Config::get('app.name') }}</title>
	<link rel="shortcut icon" type="image/png" href="resources/images/icons/favicon16.png"/>

	@foreach ($css as $each_css)
    	<link rel="stylesheet" type="text/css" href="{{url($each_css)}}">
	@endforeach

	@foreach ($js as $each_js)
    		<script type="text/javascript" src="{{url($each_js)}}"></script>
	@endforeach

</head>
<body @if(Auth::user()) style='padding-top: 55px' @endif>

  @if (!Auth::guest())
	@include('navbar')
	@include('messages')
  @endif

  

  @yield('content')


<div id='whatsup' class='panel panel-primary' ></div>

<footer id='footer' style='bottom:0;position:relative;'>
        <div class='container main-container'>
            <p class='text-muted credit' >
	          {{ Config::get('app.name') }} &copy 2015 - {{ date('Y') }} <a href='http://www.twitter.com/timottarjani'>Timot Tarjani</a> 
	          &nbsp&nbsp<a href='https://github.com/ttimot24/HorizontCMS'><i style='font-size: 18px;' class="fa fa-github" aria-hidden="true"></i></a>

			</p>
		</div>	
</footer>


<script>
	$(document).ready(function() {  
	    $("html").niceScroll({cursorwidth: "10px",zindex: "auto",autohidemode: false});
	});
</script>

</body>
</html>