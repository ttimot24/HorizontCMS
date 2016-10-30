<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Update extends Model{

	protected $table = 'system_upgrade';

	public static function avalable(){
		return file_get_contents(\Config::get('horizontcms.sattelite_url'));
	}



}
