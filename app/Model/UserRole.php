<?php

namespace App\Model;

use \App\Libs\Model;

class UserRole extends Model{
   
	//protected $table = 'user_ranks';

	public function users(){
		$this->hasMany(\App\User::class,'id','rank');
	}


}
