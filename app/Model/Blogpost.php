<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blogpost extends Model
{
    
    public function getImage(){
    	return url("blogpost image url");
    }


}
