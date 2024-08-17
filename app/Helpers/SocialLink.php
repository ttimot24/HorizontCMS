<?php

use \Illuminate\Database\Eloquent\Model;

class SocialLink extends Model {
  
  	protected $table = 'settings';
  	public $timestamps = false;


  	public function getName(){
  		return str_replace("social_link_","",$this->setting);
  	}

	public static function all($columns = array()){
		return self::where('setting','LIKE','social_link_%')->get();
	}

	public static function getLinkTo($social_media){

		$media = self::where('setting','LIKE','social_link_'.strtolower($social_media))->first();
		return $media==null? "" : $media->value;
	}


}
