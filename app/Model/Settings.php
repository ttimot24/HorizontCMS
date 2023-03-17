<?php

namespace App\Model;

use \App\Libs\Model;

class Settings extends Model {
  
  	protected $table = 'settings';
  	public $settings;
  	private static $static_settings = null;

	public static function get($setting,$default = null, bool $valueCheck = false){

		if(!$valueCheck && self::has($setting)){
			return self::$static_settings[$setting];
		}

		if($valueCheck && self::has($setting) && self::$static_settings[$setting]!=""){
			return self::$static_settings[$setting];
		}
		
		return $default;
	}

	public static function has($setting){
		if(self::$static_settings==null){
			self::$static_settings = self::getAll();	
		}

		return array_key_exists($setting,self::$static_settings);
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
