<?php 


class GoogleMaps extends Plugin{


	public function getSetting($variable){
		$stmt = $this->connection->prepare("SELECT * FROM ".PREFIX."settings WHERE setting= :key");
		$stmt->execute(['key' => $variable]);

		$row = $stmt->fetch();

		return $row['value'];
	}

	public function saveSetting($variable,$value){
		$stmt = $this->connection->prepare("UPDATE ".PREFIX."settings SET value= :value WHERE setting= :setting ");
		$stmt->execute([':value' => $value,':setting' => $variable]);
		$this->error->addError($stmt->errorInfo());

		return $this->error;
	}


	public function getApiKey(){
		return $this->getSetting('gmaps_api_key');
	}


	public function includeScript(){
		echo "<script src='http://maps.googleapis.com/maps/api/js?key=". $this->getApiKey() ."'></script>";
	}


	public function initalizeMap(){

		$this->places = $this->get_all();


		echo "<script>
					function initialize() {

					  var mapProp = {
					    center: new google.maps.LatLng(".$this->places[0]->latitude.",".$this->places[0]->longitude."),
					    zoom: ".$this->getSetting('gmaps_zoom').",
					   /* mapTypeId:google.maps.MapTypeId.".$this->getSetting('gmaps_type')."*/
					    mapTypeId: '".$this->getSetting('gmaps_type')."'

					  };


						var marker = new google.maps.Marker({
						  position: new google.maps.LatLng(47.538110,21.625673),
						  animation: google.maps.Animation.BOUNCE
						  });

						var map = new google.maps.Map(document.getElementById('googleMap'),mapProp);

						marker.setMap(map);


					}
					google.maps.event.addDomListener(window, 'load', initialize);
					</script>";
	}


	public function renderMap($width = '100%',  $height = '500px' ){
		echo '<div id="googleMap" class="thumbnail" style="width:'.$width.';height:'.$height.';"></div>';
	}


	
}