<?php

namespace App\Model;

use \App\Libs\Model;
use \App\Model\Trait\HasAuthor;
use \App\Model\Trait\Draftable;

class Blogpost extends Model {

    use HasAuthor;
    use Draftable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'summary' ,'text', 'category_id', 'comments_enabled', 'active',
    ];

    protected $defaultImage = "resources/images/icons/newspaper.png";

    protected $imageDir = "storage/images/blogposts";


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

    public static function getPublished($num = null, $order = 'ASC'){
        return self::where('active','>',0)->orderBy('created_at',$order)->paginate($num);
    }

    public static function getDrafts($num = null, $order = 'ASC'){
        return self::where('active',0)->get()->orderBy('created_at',$order)->paginate($num);
    }

    public static function getFeatured($num = null, $order = 'ASC'){
        return self::where('active',2)->orderBy('created_at',$order)->paginate($num);
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

    public function isFeatured(){
        return $this->active == 2;
    }

    public static function search($search_key){

        $search_key = '%'.$search_key.'%';

        return self::where('title', 'LIKE' ,$search_key)->orWhere('summary', 'LIKE' ,$search_key)->orWhere('text', 'LIKE' ,$search_key)->get();
    }


}
