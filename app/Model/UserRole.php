<?php

namespace App\Model;

use \App\Libs\Model;

class UserRole extends Model{
   
	//protected $table = 'user_ranks';

	public function users(){
		$this->hasMany(\App\Model\User::class,'id','rank');
	}


}
