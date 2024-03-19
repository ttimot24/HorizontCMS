<?php

namespace App\Model\Trait;
 
trait Draftable {

    public function isDraft(){
        return $this->active == 0;
    }

}