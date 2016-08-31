<form action='' method='POST'>
  <div class="form-group">
    <label for="gmaps_api_key">API Key</label>
    <input type="text" class="form-control" id="gmaps_api_key" name='api_key' placeholder="API key" value='<?= $google_maps->getApiKey(); ?>'>
  </div>

  <div class="form-group col-md-6">
    <label for="exampleInputPassword1">Zoom</label>
    <input type="number" class="form-control" id="exampleInputPassword1" name='gmaps_zoom' value=<?= $google_maps->getSetting('gmaps_zoom'); ?> >
  </div>


<?php $map_types = ['roadmap','satellite','hybrid','terrain']; ?>


  <div class="form-group col-md-6">
    <label for="gmap_type">Zoom</label>
    <select name='gmaps_type' id="gmap_type" class="form-control" >
    	<?php 

    		foreach($map_types as $type){

    			if($type == $google_maps->getSetting('gmaps_type')){
    				$select = 'selected';
    			}else{
    				$select = '';
    			}

    			echo "<option value='".$type."' ".$select.">".$type."</option>";
    		}

    	?>
    </select>
  </div>
  

  <button type="submit" class="btn btn-success btn-block">Save</button>

</form>