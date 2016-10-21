<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model{
  
  	protected $table = 'settings';
  	public $settings;

	public static function get($setting){
		$result = self::where('setting',$setting)->first();

		return $result->value;
	}


	public function assignAll(){
		$settings = self::All();

		$this->settings = new \stdClass();

		foreach($settings as $each){

			if(!empty($each->setting)){
				$this->settings->{$each->setting} = $each->value;
			}
		
		}


	}



}
