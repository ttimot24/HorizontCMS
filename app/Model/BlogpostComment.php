<?php

namespace App\Model;

use \App\Libs\Model;

class BlogpostComment extends Model{
    //

	public function blogpost(){
		return $this->belongsTo(\App\Model\Blogpost::class,'blogpost_id','id');
	}

	public function user(){
		return $this->belongsTo(\App\Model\User::class,'user_id','id');
	}




}
