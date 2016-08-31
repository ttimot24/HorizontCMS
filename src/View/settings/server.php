<div class='container main-container'>
<h1>Server Information</h1>
<br><br>

<table class='table table-bordered'>
<thead>
	<th>Name</th>
	<th>Value</th>
</thead>
<?php 
	
	$keys = array_keys($_SERVER);

	foreach($keys as $key){
		echo "<tr>";
		echo "<td><b>". $key .": </b></td> <td>" .$_SERVER[$key] ."</td>";
		echo "</tr>";
	}


?>

</table>
</div>