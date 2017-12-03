<?php

namespace App\Libs;

class Model extends \Illuminate\Database\Eloquent\Model{
    
    private $rules = array();

    protected $defaultImage = null;

    /**
     * Override the original Eloquent method to extend with retrieved event, 
     * introduced in Laravel 5.5
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = $this->newInstance([], true);

        $model->setRawAttributes((array) $attributes, true);

        $model->setConnection($connection ?: $this->getConnectionName());

        $model->fireModelEvent('retrieved', false);

        return $model;
    }




    public function hasImage(){
        return (isset($this->image) && $this->image!="");
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

/*
    public static function search($search,array $in){

        $array = [];

        foreach($in as $i){
            $array[$i] = $search; 
        }


        return self::where($array);
    }*/


    public function validate($data){
        $v = Validator::make($data, $this->rules);
        return $v->passes();
    }



}
