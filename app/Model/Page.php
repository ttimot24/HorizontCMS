<?php

namespace App\Model;

use \App\Libs\Model;

class Page extends Model{

    protected $defaultImage = "resources/images/icons/page.png";

    public static function home(){
        return self::find(Settings::get('home_page'));
    }

    public static function getByFunction($function){
        return self::where('url',$function)->get()->first();        
    }


    public static function findBySlug($slug){

        $page = self::where('slug',$slug)->get()->first();

        if($page!=NULL){
            return $page;
        }else{

            foreach (self::where('slug',NULL)->orWhere('slug',"")->get() as $page) {
                if(str_slug($page->name)==$slug){
                    return $page;
                }
            }

        }

        return NULL;
    }

    public static function activeMain(){
         return self::where('visibility',1)->where('parent_id',NULL)->get();
    }

    public static function active(){
        return self::where('visibility',1)->get();
    }

    public function isParent(){
        return $this->parent_id==NULL;
    }

    public function hasSubpages(){
        return $this->subpages->count()>0;
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id','id');
    }


    public function subpages(){
        return $this->hasMany(self::class,'parent_id','id');
    }


   	public function getThumb(){

        if($this->hasImage() && file_exists("storage/images/pages/thumbs/".$this->image)){
            return url("storage/images/pages/thumbs/".$this->image);
        }else{
            return $this->getImage();
        }

	}

    public function getImage(){

    	if($this->hasImage() && file_exists("storage/images/pages/".$this->image)){
    		return url("storage/images/pages/".$this->image);
    	}else{
    		return url($this->defaultImage);
    	}

    }


    public static function search($search_key){

        return self::where('name', 'LIKE' ,$search_key)->orWhere('page', 'LIKE' ,$search_key)->get();

    }


}
