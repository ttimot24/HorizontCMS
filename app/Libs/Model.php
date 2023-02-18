<?php

namespace App\Libs;

abstract class Model extends \Illuminate\Database\Eloquent\Model {
    
    private $rules = array();

    protected $defaultImage = null;
    protected $imageDir = null;


    public function hasImage(){
        return (isset($this->image) && !empty($this->image));
    }

    public function getThumb(){

        if($this->hasImage() && file_exists($this->imageDir."/thumbs/".$this->image)){
            return url($this->imageDir."/thumbs/".$this->image);
        }else{
            return $this->getImage();
        }

	}

    public function getImage(){

    	if($this->hasImage() && file_exists($this->imageDir."/".$this->image)){
    		return url($this->imageDir."/".$this->image);
    	}else{
    		return url($this->defaultImage);
    	}

    }

    public function getDefaultImage(){
        return $this->defaultImage;
    }


    public function setDefaultImage($image){
        $this->defaultImage = $image;
    }

    public function equals($other){

        return is_null($other)? false : $this->is($other);
    }

    public function validate($data){
        $v = Validator::make($data, $this->rules);
        return $v->passes();
    }

}
