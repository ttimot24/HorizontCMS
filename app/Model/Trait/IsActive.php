<?php

namespace App\Model\Trait;
 
trait IsActive {

    public function activate(){
        $this->active = 1;
    }

    public function deactivate(){
        $this->active = 0;
    }

    public function isActive(){
        return $this->active > 0;
    }

    public function isInActive(){
        return $this->active == 0;
    }

    public function scopeActive($query){
        return $query->where('active', '>', 0);
    }

    public function scopeInActive($query){
        return $query->where('active', 0);
    }

}