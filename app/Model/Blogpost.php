<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blogpost extends Model{
    


    public function getAuthor(){
    	//return User::find($this->author);
    }   

	public function getCategory(){
		return BlogpostCategory::find($this->category);
	}


    public function getImage(){
    	return url("blogpost image url");
    }


}
