<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blogpost extends Model{
    


    public function author(){
    	 return $this->belongsTo(User::class,'author','id');
    }   

	public function getCategory(){
		return BlogpostCategory::find($this->category);
	}


	public function comments(){
		 return $this->hasMany(BlogpostComment::class,'blogpost_id','id');
	}


	public function getThumb(){
		return $this->getImage();
	}

    public function getImage(){

    	if(file_exists("storage/images/blogposts/".$this->image)){
    		return url("storage/images/blogposts/".$this->image);
    	}else{
    		return url("resources/images/icons/newspaper.png");
    	}

    }


}
