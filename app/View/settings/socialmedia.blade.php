@extends('layout')

@section('content')
<div class='container main-container'>

<h1>Social media</h1>
<br><br>

<form action='' role='form' method='POST'>

<table class='table-bordered' id='settings' style='width:100%;text-align:center;'>

<tbody style='text-align:center;font-weight:bolder;'>

<?php 
	
	foreach($all_socialmedia as $each){

		echo "<tr><td>
				<i class='fa fa-".$each."' aria-hidden='true' style='font-size:26px;'></i> ".ucfirst($each)."</td><td>
				<input type='text' class='form-control' name='".$each."' value='".htmlspecialchars($each)."'>
			</td></tr>";


	}



?>


<tr><td></td>
<td><button type='submit' class='btn btn-primary'>
		<span class='glyphicon glyphicon-floppy-save' aria-hidden='true'></span> Save settings</button> </td></tr>



</tbody></table>
</form>

</div>
@endsection