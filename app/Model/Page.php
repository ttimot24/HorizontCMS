<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model{


    public function parent(){
        return $this->belongsTo(Page::class,'parent','id');
    }


    public function subpages(){
        return $his->hasMany(Page::class,'parent','id');
    }


   	public function getThumb(){

        if(file_exists("storage/images/pages/thumbs/".$this->image)){
            return url("storage/images/pages/thumbs/".$this->image);
        }else{
            return $this->getImage();
        }

	}

    public function getImage(){

    	if(file_exists("storage/images/pages/".$this->image)){
    		return url("storage/images/pages/".$this->image);
    	}else{
    		return url("resources/images/icons/page.png");
    	}

    }
}
