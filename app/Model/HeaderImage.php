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
        'title', 'link' ,'description', 'image', 'active',
    ];
    
    public $timestamps = false;

    protected $imageDir = "storage/images/header_images";

    public function author(){
        return $this->belongsTo(\App\Model\User::class,'author_id','id'); //In db it has to be author_id else it won't work because Laravel priority is attr -> function
    }   

    public static function getActive($order = 'ASC'){
        return self::where('active','>',0)->orderBy('order',$order);
    }

    public static function getInactive($order = 'ASC'){
        return self::where('active','=',0)->orderBy('order',$order);
    }

}
