<?php

namespace App\Model;

use \App\Libs\Model;

class BlogpostCategory extends Model
{
	protected $imageDir = "storage/images/blogpost_category";

	public $timestamps = false;
    
	public function blogposts(){
		 return $this->hasMany(\App\Model\Blogpost::class,'category_id','id');
	}


}
