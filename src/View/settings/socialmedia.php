<div class='container main-container'>

<h1>Social media</h1>
<br><br>

<form action='' role='form' method='POST'>

<table class='table-bordered' id='settings' style='width:100%;text-align:center;'>

<tbody style='text-align:center;font-weight:bolder;'>

<?php 
	
	foreach($data['all'] as $each){

		echo "<tr><td>
				<i class='fa fa-".$each->social_media."' aria-hidden='true' style='font-size:26px;'></i> ".ucfirst($each->social_media)."</td><td>
				<input type='text' class='form-control' name='".$each->social_media."' value='".htmlspecialchars($each->link,ENT_QUOTES)."'>
			</td></tr>";


	}



?>


<tr><td></td>
<td><button type='submit' class='btn btn-primary'>
		<span class='glyphicon glyphicon-floppy-save' aria-hidden='true'></span> Save settings</button> </td></tr>



</tbody></table>
</form>

</div>