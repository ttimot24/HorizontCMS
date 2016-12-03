<?php

namespace App\Libs;

class Model extends \Illuminate\Database\Eloquent\Model{
    
    private $rules = array();


    public function hasImage(){
        return (isset($this->image) && $this->image!="");
    }

    public function equals(Model $other){
        return $this->is($other);
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
