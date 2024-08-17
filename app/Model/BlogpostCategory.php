<?php

namespace App\Model;

use App\Model\Trait\HasAuthor;
use App\Model\Trait\HasImage;
use \Illuminate\Database\Eloquent\Model;

class BlogpostCategory extends Model {

    use HasAuthor;
    use HasImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

	protected $imageDir = "storage/images/blogpost_category";

	public $timestamps = false;
    
	public function blogposts(){
		 return $this->hasMany(\App\Model\Blogpost::class,'category_id','id');
	}


}
