<?php

namespace App\Model;

use \App\Libs\Model;

class Blogpost extends Model{
    
    private $rules = array(
                        'title' => 'required',
                        );


    protected $defaultImage = "resources/images/icons/newspaper.png";


    public static function findBySlug($slug){

        $blogpost = self::where('slug',$slug)->get()->first();

        if($blogpost!=NULL){
            return $blogpost;
        }else{

            foreach (self::where('slug',NULL)->orWhere('slug',"")->get() as $blogpost) {
                if(str_slug($blogpost->title)==$slug){
                    return $blogpost;
                }
            }

        }

        return NULL;
    }

    public static function getPublished(){
        return self::where('active','>',0)->get();
    }

    public static function getDrafts(){
        return self::where('active',0)->get();
    }

    public static function getFeatured(){
        return self::where('active',2)->get();
    }

    public function author(){
    	 return $this->belongsTo(\App\Model\User::class,'author_id','id'); //In db it has to be author_id else it won't work because Laravel priority is attr -> function
    }   

	public function category(){

        return $this->hasOne(BlogpostCategory::class,'id','category_id'); //In db it has to be category_id else it won't work because Laravel priority is attr -> function
	}


	public function comments(){
		 return $this->hasMany(BlogpostComment::class,'blogpost_id','id');
	}


    public function getSlug(){
        return ($this->slug!=NULL && $this->slug!="")? $this->slug : str_slug($this->title);
    }

	public function getThumb(){

        if($this->hasImage() && file_exists("storage/images/blogposts/thumbs/".$this->image)){
            return url("storage/images/blogposts/thumbs/".$this->image);
        }else{
            return $this->getImage();
        }

	}

    public function getImage(){

    	if($this->hasImage() && file_exists("storage/images/blogposts/".$this->image)){
    		return url("storage/images/blogposts/".$this->image);
    	}else{
    		return url($this->defaultImage);
    	}

    }


    public function getExcerpt($char_num = 255){

        if(isset($this->summary) && $this->summary!=""){
            return $this->summary;
        }else{
            return substr(strip_tags($this->text),0,$char_num);
        }
    }

    public function getTotalCharacterCount(){
        return strlen(strip_tags($this->text));
    }

    public function getTotalWordCount(){
        return str_word_count(strip_tags($this->text));
    }

    public function getReadingTime(){
        return ($this->getTotalWordCount()/200)*60;
    }

    public function isPublished(){
        return $this->active > 0;
    }

    public function isDraft(){
        return $this->active == 0;
    }

    public function isFeatured(){
        return $this->active == 2;
    }

    public static function search($search_key){

        $search_key = '%'.$search_key.'%';

        return self::where('title', 'LIKE' ,$search_key)->orWhere('summary', 'LIKE' ,$search_key)->orWhere('text', 'LIKE' ,$search_key)->get();
    }


}
