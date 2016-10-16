<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model{
  
  	protected $table = 'settings';

	public static function get($setting){
		$result = self::where('setting',$setting)->first();

		return $result->value;
	}



}
