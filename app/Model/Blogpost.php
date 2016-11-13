<?php

namespace App\Model;

use \App\Libs\Model;

class Blogpost extends Model{
    
    private $rules = array(
                        'title' => 'required',
                        );

    public function author(){
    	 return $this->belongsTo(\App\User::class,'author_id','id'); //In db it has to be author_id else it won't work because Laravel priority is attr -> function
    }   

	public function category(){

        return $this->hasOne(BlogpostCategory::class,'id','category_id'); //In db it has to be category_id else it won't work because Laravel priority is attr -> function
	}


	public function comments(){
		 return $this->hasMany(BlogpostComment::class,'blogpost_id','id');
	}


	public function getThumb(){

        if(file_exists("storage/images/blogposts/thumbs/".$this->image) && $this->image!=""){
            return url("storage/images/blogposts/thumbs/".$this->image);
        }else{
            return $this->getImage();
        }

	}

    public function getImage(){

    	if(file_exists("storage/images/blogposts/".$this->image) && $this->image!=""){
    		return url("storage/images/blogposts/".$this->image);
    	}else{
    		return url("resources/images/icons/newspaper.png");
    	}

    }


}
