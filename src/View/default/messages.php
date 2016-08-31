<div class='container' style='max-width:100%;'>

	<?php 
			 if($this->message->hasMessage()){
			 	foreach($this->message->getMessage() as $each){
	  				echo $each;
	  			}
	  		
	  		}   
	?>

</div>