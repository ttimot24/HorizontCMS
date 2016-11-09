@extends('layout')

@section('content')
<div class='container main-container'>



<h2 style='width:65%;' class='pull-left'>Gallery</h2>

	<div style='margin-top:2%;'>
		<form action='admin/gallery/newgallery' method='POST'>
		 <div class='form-group'>
            <div class='input-group'>
            <input type='text' class='form-control' name='new_gallery' id='exampleInputAmount' style='width:250px;' placeholder='Add new dir' required>
			<button type='submit' class='btn btn-primary btn-md'>Add new dir</button>
			</div>
		 </div>
		</form>
	</div>

<?php 



echo "<div class='container'>";
foreach($galleries as $each){

	$images = array_slice(scandir(Storage::$path."/images/gallery/".$each->directory."/"),2);


	echo "<h3><a href='admin/gallery/open/".$each->directory."'>".$each->name."(".count($images).")</a> 
	<button type='button' class='btn btn-primary btn-xs' data-toggle='modal' data-target='.upload_".$each->directory."'>Upload images</button> 
	<button type='button' class='btn btn-warning btn-xs' data-toggle='modal' data-target='.rename_".$each->directory."' >Rename gallery</button> 
	<button type='button' class='btn btn-danger btn-xs' data-toggle='modal' data-target='.".$each->directory."'>Delete gallery</button></h3>";


 Bootstrap::delete_confirmation(
			$each->directory,
			"Are you sure?",
			"Delete this gallery: <b>" .$each->name ."</b> with all the images?",    
			"<a href='admin/gallery/delete/".$each->directory."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    			<button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>",
    		NULL);



	echo "<div class='container'>";
	$i=0;

		foreach($images as $img){

			if($i==20){
				break;
			}

			$i++;

			$modal_name = explode(".",$img);

			echo "<button type='button' class='btn btn-link' data-toggle='modal' data-target='.view_".$modal_name[0]."-modal-xl'>
					<img src='".Storage::$path."/images/gallery/".$each->directory."/".$img."' style='width:150px;height:110px;margin:-10px;object-fit:cover;' class='img img-thumbnail' />
				</button>";


			Bootstrap::image_details("view_".$modal_name[0],Storage::$path."/images/gallery/".$each->directory."/".$img);




		}

		echo "<a href='admin/gallery/open/".$each->directory."' class='img-thumbnail'><button class='btn btn-primary' style='width:155px;height:100px;' ><font size='4'>More -></font></button></a>";

	echo "</div>";

	echo "<hr/>";






echo "<div class='modal rename_".$each->directory." ' id='create_new' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-warning'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Rename gallery: ".$each->name."</h4>
      </div>
      <div class='modal-body'>
        <form class='form-horizontal' role='form' action='admin/gallery/rename/".$each->directory."' method='POST'>
			  <div class='form-group'>
			  </br>
		      <label class='control-label col-sm-3' for='pwd'>New name:</label>
		      <div class='col-sm-7'>          
		        <input type='text' name='new_name' class='form-control' id='pwd' value='".$each->name."'>
		      </div>
		    </div>	
      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-warning'>Rename</button></form>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->";




echo "<div class='modal upload_".$each->directory." ' id='create_new' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Upload images</h4>
      </div>
      <div class='modal-body'>
      <div class='container'>
        <form class='form-horizontal' role='form' action='admin/gallery/upload/".$each->directory."' method='POST' enctype='multipart/form-data'>
          <div class='form-group'>
  		      <label for='file'>Upload file:</label>
  		      <input name='up_file[]' id='input-2' type='file' class='file' multiple='true' data-show-upload='true' data-show-caption='true'>
		      </div>
        </form>
		</div>
      </div>
      <div class='modal-footer'>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->";



}
echo "</div></br>";


?>

</div>
@endsection