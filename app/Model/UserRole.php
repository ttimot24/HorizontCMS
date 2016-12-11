<?php

namespace App\Model;

use \App\Libs\Model;

class UserRole extends Model{
   
	public $timestamps = false;

	
	public function users(){
		$this->hasMany(\App\Model\User::class,'id','rank');
	}


}
