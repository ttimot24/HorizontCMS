<?php

namespace App\Model;

use \App\Libs\Model;
use App\Model\Trait\HasAuthor;

class HeaderImage extends Model {

    use HasAuthor;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'link' ,'description', 'image', 'active',
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
