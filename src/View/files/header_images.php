
<div class='container main-container'>
<h2>Header images</h2>


</br></br>
<form action='admin/headerimages/upload' method='POST' enctype='multipart/form-data'>
<div class='form-group'>
      <label for='file'>Upload file:</label>
      <input name='up_file[]' id='input-2' type='file' accept='image/*' class='file' multiple='true' data-show-upload='true' data-show-caption='true'>
    </div>
</form>

    </br></br>

<div class='container'>
	<h3>Currently on the slider:</h3>

	<?php 

	if(count($data['slider_images']) > 0){
		foreach($data['slider_images'] as $image){
			echo "<div class='img-thumbnail col-md-3' style='height:150px;'>";
			echo Html::img(Storage::get('image','header_images/'.$image->image),"style='width:100%;height:85%;'");
			echo "<a class='btn btn-danger btn-xs btn-block' href='admin/headerimages/getoffslider/".$image->id."'>Remove from slider</a>";
			echo "</div>";
		}
	}
	else{
		echo " <h4> No images on the slider!</h4>";
	}

	?>

</div>

<div class='container'>
	<h3>Available images:</h3>

<?php 
foreach($data['dirs'] as $each){
	echo "<div class='col-md-3 img img-thumbnail'  style='margin-bottom:5%;height:200px;'>";
	echo "<a class='btn-sm btn-success col-md-6' href='admin/headerimages/addtoslider/".$each."'>Add to slider</a>";
	echo "<a href='admin/headerimages/delete/".$each."' class='pull-right'>
	<span class='glyphicon glyphicon-remove' aria-hidden='true' style=' font-size: 1.4em;z-index:15;top:3px;right:3px;margin-bottom:-15px;'></span></a>";

	//echo "<img src='images/header_images/".$each."' alt='' class='img-rounded' width='100%' height='80%;'>";
	echo Html::img(Storage::get('image','header_images/'.$each),"class='img-rounded' width='100%' height='80%;'");
	echo "</div>";

}
?>

</div>


</br></br></br>


</div>