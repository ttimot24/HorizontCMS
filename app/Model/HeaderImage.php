<?php

namespace App\Model;

use \App\Libs\Model;

class HeaderImage extends Model
{
    public $timestamps = false;

    public static function getActive($order = 'ASC'){
        return self::where('active','>',0)->orderBy('order',$order);
    }

    public static function getInactive($order = 'ASC'){
        return self::where('active','=',0)->orderBy('order',$order);
    }

    public function getImage(){

    	if($this->hasImage() && file_exists("storage/images/header_images/".$this->image)){
    		return url("storage/images/header_images/".$this->image);
    	}else{
    		return "";
    	}

    }
}
