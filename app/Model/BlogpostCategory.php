<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BlogpostCategory extends Model
{
    
	public function blogposts(){
		 return $this->hasMany(\App\Model\Blogpost::class,'id','category_id');
	}


}
