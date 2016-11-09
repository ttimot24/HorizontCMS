<?php

namespace App\Libs;

class Model extends Illuminate\Database\Eloquent\Model{
    
    private $rules = array();


    public function equals($other){
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


   /* public function save(array $options = array())
    {
        if($this->validate())
            return parent::save($options);

        return false;
    }
*/

}
