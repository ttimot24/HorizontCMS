<div class='container main-container'>

<h2>Notifications</h2>

<div class="list-group">

<?php 

//var_dump($data['notifications'][0]);

foreach($data['notifications'] as $notifications){
	echo '<a class="list-group-item"> <span class="badge">'.date('Y. m. d. - H:i:s',$notifications[2]).'</span> <i class="fa fa-'.$notifications[0].'" style="font-size:20px;" aria-hidden="true"></i>
'.$notifications[1].'</a>';
}

?>

 

  <a href="#" class="list-group-item active"> <span class="badge">2014. 02. 13. </span>  HorizontCMS installed succesfully! </a>
</div>

</div>