<div class='container main-container'> 

<?php


echo "<h3 style='width:40%;' class='pull-left'>".$data['gallery_name']."(".$data['count'].")</h3>";
echo "<button class='btn btn-danger' data-toggle='modal' data-target='.delete_selected' style='margin-top:15px;'>Delete selected images</button>";
echo "</br></br>";

echo "<form action='admin/gallery/deleteselected/' method='POST'>";


	echo "<div class='container' style='clear:both;'>";

		foreach($data['images'] as $img){

			$modal_name = explode(".",$img);

			echo "<div style='float:left;'><button type='button' class='btn btn-link' data-toggle='modal' data-target='.view_".$modal_name[0]."-modal-xl'>
					<img class='img img-thumbnail' src='".Storage::$path."/images/gallery/".$data['current_dir']."/".$img."' style='width:150px;height:100px;margin:-10px;'/>
				</button>
				</br>
				<input type='hidden' name='dir' value='".$data['current_dir']."' >
				<center><input type='checkbox' name='delete_img[]' value='".$img."'/></center>
				</br>
				</div>";
		

			Bootstrap::image_details("view_".$modal_name[0],Storage::$path."/images/gallery/".$data['current_dir']."/".$img);
					


		}

	echo "</div>";


	Bootstrap::delete_confirmation(
			"delete_selected",
			"Are you sure?",
			"Delete all the selected images?",    
			"<button type='submit' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    			<button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>",
    		NULL);

echo "</form>";
?>

</div>