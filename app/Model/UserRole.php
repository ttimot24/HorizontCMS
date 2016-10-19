<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model{
   
	protected $table = 'user_ranks';

	public function users(){
		$this->hasMany(\App\User::class,'id','rank');
	}


}
