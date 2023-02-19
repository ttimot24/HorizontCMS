<?php

namespace App\Model;

use \App\Libs\Model;

class HeaderImage extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'link' ,'description', 'active',
    ];
    
    public $timestamps = false;

    protected $imageDir = "storage/images/header_images";

    public static function getActive($order = 'ASC'){
        return self::where('active','>',0)->orderBy('order',$order);
    }

    public static function getInactive($order = 'ASC'){
        return self::where('active','=',0)->orderBy('order',$order);
    }

}
