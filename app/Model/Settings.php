<?php

namespace App\Model;

use \App\Libs\Model;

class Settings extends Model{
  
  	protected $table = 'settings';
  	public $timestamps = false;
  	public $settings;

	public static function get($setting,$default = null){

		$result = self::where('setting',$setting)->first();

		return $result==null? $default : $result->value;
	}

	public static function getAll(){

		foreach(self::all() as $each){
			$array[$each->setting] = $each->value;
		}


		return $array;
	}


	public function assignAll(){
		$settings = self::all();

		$this->settings = new \stdClass();

		foreach($settings as $each){

			if(!empty($each->setting)){
				$this->settings->{$each->setting} = $each->value;
			}
		
		}


	}



}
