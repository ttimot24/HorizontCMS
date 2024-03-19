<?php

namespace App\Model\Trait;
 
trait Searchable {

    public function scopeSearch($query, $search_key){

        $search_key = '%'.$search_key.'%';

        foreach($this->search as $column){
            $query = $query->orWhere($column, 'LIKE', $search_key);
        }

        return $query;
    }

}