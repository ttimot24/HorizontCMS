<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model{


    public static function findBySlug($slug){
        return self::where('slug','=',$slug)->get()->first();
    }


    public function parent(){
        return $this->belongsTo(self::class,'parent_id','id');
    }


    public function subpages(){
        return $this->hasMany(self::class,'parent_id','id');
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
