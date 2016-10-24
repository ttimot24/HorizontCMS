<?php

namespace App\Libs;

class Model extends Illuminate\Database\Eloquent\Model{
    
    public function equals(Model $other){
        return $this->is($other);
    }


    public static function search($search,array $in){

        $array = [];

        foreach($in as $i){
            $array[$i] = $search; 
        }


        return self::where($array);
    }


}
