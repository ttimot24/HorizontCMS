<?php

namespace App\Model;

use \Illuminate\Database\Eloquent\Model;
use App\Model\Trait\HasAuthor;
use App\Model\Trait\HasImage;
use App\Model\Trait\IsActive;

class HeaderImage extends Model {

    use HasImage;
    use HasAuthor;
    use IsActive;

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

    //TODO Use local scope
 /*   public static function getActive($order = 'ASC'){
        return self::where('active','>',0)->orderBy('order',$order);
    } */

    //TODO Use local scope
 /*   public static function getInactive($order = 'ASC'){
        return self::where('active','=',0)->orderBy('order',$order);
    } */

}
