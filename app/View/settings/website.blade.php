@extends('layout')

@section('content')
<div class='container main-container'>

<h1>Website settings</h1><br><br>

<form action='admin/settings/website' role='form' method='POST'>
{{ csrf_field() }}

<table class='table-bordered' id='settings' style='width:100%;text-align:center;'>

<tbody style='font-weight:bolder;'>

<tr><td class='col-md-4'>Title<br><small class='text-muted'>What you write here, will be the name of the browser page.</small></td>
<td><input type='text' class='form-control' name='title' value="{{$settings['title']}}"></td></tr>

<tr><td>Site name</td><td><input type='text' class='form-control' name='site_name' value="{{$settings['site_name']}}"></td></tr>

<tr><td>Slogan</td><td><input type='text' class='form-control' name='slogan' value="{{$settings['slogan']}}"></td></tr>

<tr><td>Warning text</td><td><input type='text' class='form-control' name='scroll_text' value="{{$settings['scroll_text']}}"></td></tr>

<tr><td>Debug mode</td><td>
<div class='form-group pull-left col-xs-12 col-md-8' style='margin-top:20px;margin-bottom:20px;'>
        <div class="radio radio-primary radio-inline">
                        <input type="radio" id="inlineRadio1" value="1" name='website_debug' <?php if( $settings['website_debug']==1){echo "checked"; } ?>>
                        <label for="inlineRadio1">On</label>
        </div>

                    <div class="radio radio-inline">
                        <input type="radio" id="inlineRadio2" value="0" name='website_debug' <?php if($settings['website_debug']==0){echo "checked"; } ?>>
                        <label for="inlineRadio2">Off</label>
                    </div>
</div>
</td></tr>

<tr><td>Contact info</td><td><textarea rows='7' class='form-control' name='contact' cols='30'>{{ $settings['contact'] }}</textarea></td></tr>

<input type="hidden" name="website_down" value="0"> <!-- Checkbox hack -->
<tr><td>Website down</td><td><input type='checkbox' class='form-control' name='website_down' value='1' <?php if($settings['website_down']==1){ echo 'checked'; } ?> ></td></tr>

<input type="hidden" name="use_https" value="0"> <!-- Checkbox hack -->
<tr><td>Secure site with SSL (https)</td><td><input type='checkbox' class='form-control' name='use_https' value='1' <?php if($settings['use_https']==1){ echo 'checked'; } ?> ></td></tr>


<tr><td>Logo</td><td>
<br>
@if(isset($settings['logo']) && $settings['logo']!='' && file_exists('storage/images/logos/'.$settings['logo']))
<img class='well well-sm' src="storage/images/logos/{{$settings['logo']}}" height='100'>
@endif

<div class="btn-group" role="group">
<button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='.admin_logo_select-modal-lg'>Select</button>
<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='.admin_logo_upload-modal-lg'>Upload</button>
</div>

</td></tr>

<tr><td>Website type</td><td>
						<select name='website_type' class='form-control'>
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
        {{ csrf_field() }}
          <div class='form-group'>
  		      <label for='file'>Upload file:</label>
  		      <input name='up_file[]' accept='image/*' id='input-2' type='file' class='file' multiple='true' data-show-upload='true' data-show-caption='true'>
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

	        foreach ($available_logos as $each){
	        	echo "<a href='admin/settings/setlogo/".$each."'>
            <img class='img img-thumbnail settings-image' src='storage/images/logos/".$each."' width='150'></a>";
	        }

?>

        </div>
      </div>
    </div>
  </div>
@endsection