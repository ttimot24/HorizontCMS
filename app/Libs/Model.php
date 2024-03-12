<?php

namespace App\Libs;

use \App\Model\Trait\HasImage;

abstract class Model extends \Illuminate\Database\Eloquent\Model {

    use HasImage;
    
    private $rules = array();

    public function equals($other){

        return is_null($other)? false : $this->is($other);
    }

    public function validate($data){
        $v = Validator::make($data, $this->rules);
        return $v->passes();
    }

}
