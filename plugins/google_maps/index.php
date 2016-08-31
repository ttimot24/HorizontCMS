<section class='container'>

<?php
require_once("plugins/google_maps/model/GoogleMaps.php");

 $slugs = array_slice(UrlManager::get_slugs(),1);

if(!GoogleMaps::is_installed('google_maps')){
    echo "<div class='jumbotron'>
    				<h2>Google Maps application is not installed!</h2>
    	  </div>";
    return -1;

}

$google_maps = new GoogleMaps();


if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(isset($_POST['api_key'])){
		$google_maps->saveSetting('gmaps_api_key',$_POST['api_key']);
		$google_maps->saveSetting('gmaps_zoom',$_POST['gmaps_zoom']);
      $google_maps->saveSetting('gmaps_type',$_POST['gmaps_type']);
	}
	else{
		$google_maps->construct_by_array($_POST);
		$google_maps->setValue('active',1);

		$google_maps->save();
	}

}

?>


<div class='row'>
<h1>Google Maps</h1><br>
</div>


<div class='col-md-8'>

  <!-- Nav tabs -->
  <div class='well'>
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#new_location" aria-controls="nre_location" role="tab" data-toggle="tab">Add location</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
  </ul>
  </div>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home"><?php require_once("plugins/google_maps/view/list.php"); ?></div>
    <div role="tabpanel" class="tab-pane" id="new_location"><?php require_once("plugins/google_maps/view/add_location.php"); ?></div>
    <div role="tabpanel" class="tab-pane" id="settings"><?php require_once("plugins/google_maps/view/settings.php"); ?></div>
  </div>


</div>

<div class='col-md-4' style='text-align:right;'>
	<img src='plugins/google_maps/image/gml.png'>
</div>


 </section>