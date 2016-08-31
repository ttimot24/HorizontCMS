<title>Error - HorizontMVC</title>


<div class='jumbotron' style='margin-top:-5%;background-color:#e0b50b'><br>
	<h1 class='container'>
		<span class="glyphicon glyphicon-leaf" aria-hidden="true" style='color:green;'></span> <b><i>HorizontMVC Framework</i></b>
	</h1>
</div>
<hr/>
<div class='container'>
	<h1>
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style='color:#b71b1b;'></span> There was an error!
	</h1>
	<h4>
		<p style='padding:15px;'>
			<?php 

				  if(isset($data['message'])){
					echo $data['message'];
				  } 

				  echo "<br><br>";
			?>

			<div class='well'>
			<?php
				if(isset($data['backtrace'])){
				 	  echo "<h2>Backtrace:</h2> <br>";


					  echo '<b>File: </b>' .$data['backtrace']['file'] ."<br>";
					  echo '<b>Line: </b>' .$data['backtrace']['line'] ."<br>";
				}
			?>
			</div>
		</p>
	</h4>
</div>


