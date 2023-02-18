<?php

namespace App\Model;

use \App\Libs\Model;

class HeaderImage extends Model {
    
    public $timestamps = false;

    protected $imageDir = "storage/images/header_images";

    public static function getActive($order = 'ASC'){
        return self::where('active','>',0)->orderBy('order',$order);
    }

    public static function getInactive($order = 'ASC'){
        return self::where('active','=',0)->orderBy('order',$order);
    }

}
