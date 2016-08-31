<div class='container main-container'>

<h1>Website settings</h1>


<form action='admin/settings/website' role='form' method='POST'>

<table class='table-bordered' id='settings' style='width:100%;text-align:center;'>

<tbody style='font-weight:bolder;'>

<tr><td class='col-md-4'>Title<br><small class='text-muted'>What you write here, will be the name of the browser page.</small></td>
<td><input type='text' style='width:100%;' class='form-control' name='title' value='<?= htmlspecialchars($data['title'],ENT_QUOTES) ?>'></td></tr>

<tr><td>Site name</td><td><input type='text' class='form-control'  style='width:100%;' name='site_name' value='<?= htmlspecialchars($data['site_name'],ENT_QUOTES) ?>'></td></tr>

<tr><td>Slogan</td><td><input type='text' class='form-control'  style='width:100%;' name='slogan' value='<?= htmlspecialchars($data['slogan'],ENT_QUOTES) ?>'></td></tr>

<tr><td>Warning text</td><td><input type='text' class='form-control'  style='width:100%;' name='scroll_text' value='<?= htmlspecialchars($data['scroll_text'],ENT_QUOTES) ?>'></td></tr>

<tr><td>Debug mode</td><td>
<div class='form-group pull-left col-xs-12 col-md-8' style='margin-top:20px;margin-bottom:20px;'>
        <div class="radio radio-primary radio-inline">
                        <input type="radio" id="inlineRadio1" value="1" name='website_debug' <?php if($data['debug_mode']==1){echo "checked"; } ?>>
                        <label for="inlineRadio1">On</label>
        </div>

                    <div class="radio radio-inline">
                        <input type="radio" id="inlineRadio2" value="0" name='website_debug' <?php if($data['debug_mode']==0){echo "checked"; } ?>>
                        <label for="inlineRadio2">Off</label>
                    </div>
</div>
</td></tr>

<tr><td>Contact info</td><td><textarea rows='7' class='form-control'  style='width:100%;' name='contact' cols='30'><?= $data['contact'] ?></textarea></td></tr>

<tr><td>Website down</td><td><input type='checkbox' class='form-control'  style='width:100%;' name='website_down' value='1' <?php if($data['website_down']==1){ echo 'checked'; } ?> ></td></tr>

<tr><td>Logo</td><td>
<img class='well well-sm' src='<?= Storage::$path ?>/images/logos/<?= $data['logo'] ?>' onerror='this.src=\"storage/images/icons/world.png\"' height='100'>

<div class="btn-group" role="group">
<button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='.admin_logo_select-modal-lg'>Select</button>
<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='.admin_logo_upload-modal-lg'>Upload</button>
</div>

</td></tr>

<tr><td>Website type</td><td>
						<select name='sitetype' class='form-control'>
								<option value='website'>Website</option>
								<option value='blog'>Blog</option>
						</select>
					</td></tr>

<tr><td></td>
<td>
<br>
  <button type='submit' class='btn btn-primary btn-lg'><span class='glyphicon glyphicon-floppy-save' aria-hidden='true'></span> Save settings</button> 
<br>
</td></tr>



</tbody></table>
</form>

<div class='modal admin_logo_upload-modal-lg' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabelx' aria-hidden='true'>
  <div class='modal-dialog modal-lg'>
    <div class='modal-content'>

        <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
        <h2 class='modal-title'><center>Upload logo</center></h2>
         </div>
        <div class='modal-body'>
        <form action='admin/settings/uploadlogo' method='POST' enctype='multipart/form-data'>
          <div class='form-group'>
  		      <label for='file'>Upload file:</label>
  		      <input name='up_file[]' id='input-2' type='file' class='file' multiple='true' data-show-upload='true' data-show-caption='true'>
		      </div>
        </form>
        </div>
    </div>
  </div>
</div>



<div class='modal admin_logo_select-modal-lg' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabelx' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>

        <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
        <h2 class='modal-title'><center>Select Logo</center></h2>
         </div>
        <div class='modal-body'>
       
<?php             
        $logos = scandir(Storage::$path."/images/logos");

	        foreach (array_slice($logos,2) as $each){
	        	echo "<a href='admin/settings/setlogo/website/".$each."'>
            <img class='img img-thumbnail settings-image' src='".Storage::get('images/logo',$each)."' width='150'></a>";
	        }


?>

        </div>
      </div>
    </div>
  </div>