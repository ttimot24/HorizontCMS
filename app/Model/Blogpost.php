<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blogpost extends Model{
    


    public function getAuthor(){
    	return $this->belongsTo('App\User');
    }   

	public function getCategory(){
		return BlogpostCategory::find($this->category);
	}


	public function getComments(){
		 
	}


	public function getThumb(){
		return $this->getImage();
	}

    public function getImage(){
    	
    	if(file_exists("storage/images/blogposts/".$this->image)){
    		return url("storage/images/blogposts/".$this->image);
    	}else{
    		return "";
    	}

    }


}
