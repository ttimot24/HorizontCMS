<?php 

class HeaderImage extends Model{

	public function get_all_from_dir(){

		return Storage::findAllIn("images/header_images");
	}




}


?>