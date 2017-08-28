<html>
<body>

<header>
	<title>Exception - HorizontCMS</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</header>

<div class='jumbotron' style='background-color:#e0b50b'><br>
	<h1 class='container'>
		<span class="glyphicon glyphicon-leaf" aria-hidden="true" style='color:green;'></span> <b><i>HorizontCMS Exception</i></b>
	</h1>
</div>
<hr/>
<div class='container'>
	<h1>
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style='color:#b71b1b;'></span> There was an error!
	</h1>
	<h4>
		<p style='padding:15px;'>

			<b>Type:</b> {{get_class($exception)}}
			<br><br>
			{!! $exception->getMessage() !!} on line: {{$exception->getLine()}}<br>in: {{$exception->getFile()}}

			<br><br>
			<div class='well'>
			<h2>Backtrace:</h2> <br>
			<?php

				$counter = count($exception->getTrace())-1;

				foreach($exception->getTrace() as $trace){
			
					  echo '#'.$counter.' <b>Function: </b>' .$trace['function'] ." ";
					  if(isset($trace['file'])){ echo '<b>File: </b>' .$trace['file'] ." ";}
					  if(isset($trace['line'])){ echo '<b>Line: </b>' .$trace['line'] ."<br><hr><br>";}


					$counter--;
				}
			?>
			</div>
		</p>
	</h4>
</div>


</body>
</html>
