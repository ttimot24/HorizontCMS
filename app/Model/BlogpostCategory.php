<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BlogpostCategory extends Model
{

	public $timestamps = false;
    
	public function blogposts(){
		 return $this->hasMany(\App\Model\Blogpost::class,'category_id','id');
	}

	public function getThumb(){
		return "";
	}
	
	public function getImage(){
		return "";
	}


}
