<div class='container main-container'>
<h1>Spread</h1>

<table class='table'>
	<thead>
		<th>Dir/File</th>
		<th>Status</th>
	</thead>

	<tbody>

<?php 

	$success = 'images/icons/okey.png';
	$danger = 'images/icons/delete.png';


	foreach ($data['statuses'] as $key => $value) {
		echo "<tr class='".$value."'>
				<td><b>This: </b> " .$key ."</td>
				<td><center><img src='".${$value}."' width='20' ></center></td>
			  </tr>";
	}

?>

	</tbody>
</table>


</div>