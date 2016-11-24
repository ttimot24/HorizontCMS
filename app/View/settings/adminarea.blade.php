@extends('layout')

@section('content')
<div class='container main-container'>

<h1>AdminArea settings</h1>


<form action='' role='form' method='POST'>

    {{ csrf_field() }}
<input type='hidden' name='is_actioned' value='1'>
<table class='table-bordered' id='settings' style='width:100%;text-align:center;'>

<tbody style='text-align:center;font-weight:bolder;'>


<tr><td>Admin theme</td><td><select name='admin_theme' class='form-control' style='width:100%;'>
                                        <option value=''>default</option>
                                        <!--<option value='lightthm'>Light</option>-->
                                        <option value='darktheme'>Dark</option>
                                    </select></td></tr>

<tr><td>Dashboard Logo</td><td>
<img class='well well-sm' src="storage/images/logos/{{$settings['admin_logo']}}" onerror='this.src=\"storage/images/logos/world.png\"' height='100'>

<div class="btn-group" role="group">
<button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='.admin_logo_select-modal-lg'>Select</button>
<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='.admin_logo_upload-modal-lg'>Upload</button>
</div>

</td></tr>

<tr><td>Language</td><td><select name='language' class='form-control' style='width:100%;'>

              

                @foreach($languages as $key => $language)

                  @if($language == $settings['language'])
                    <option value='{{$key}}' selected>{{ucfirst($language)}}</option>
                  @else
                    <option value='{{$key}}'>{{ucfirst($language)}}</option>
                  @endif

                @endforeach


  
						</select>
				</td></tr>

<tr><td>Automatically check for updates</td><td><input class='form-control' type='checkbox' value="1"/></td>

<tr><td></td><td></br><button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-floppy-save' aria-hidden='true'></span> Save settings</button> </td></tr>


</tbody></table>
</form>




<div class='modal admin_logo_upload-modal-lg' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
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



<div class='modal admin_logo_select-modal-lg' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>

        <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
        <h2 class='modal-title'><center>Select Logo</center></h2>
         </div>
        <div class='modal-body'>

<?php             
        /*$logos = scandir("storage/images/logos");


	        foreach (array_slice($logos,2) as $each){
	        	echo "<a href='admin/settings/setlogo/admin_logo/".$each."'><img src='storage/images/logos/".$each."' class='img img-thumbnail settings-image' width='150'></a>";
	        }*/
?>

 </div>
    </div>
  </div>
</div>



</div>
@endsection