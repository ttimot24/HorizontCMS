<?php

namespace App\Model;

use \App\Libs\Model;

class HeaderImage extends Model
{
    public $timestamps = false;

    public function getImage(){

    	if($this->hasImage() && file_exists("storage/images/header_images/".$this->image)){
    		return url("storage/images/header_images/".$this->image);
    	}else{
    		return "";
    	}

    }
}
