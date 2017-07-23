<?php

namespace App\Model;

use \App\Libs\Model;

class Plugin extends Model
{
    public $timestamps = false;
    protected $fillable = ['id','root_name','area','permission','table_name','active'];

    public static function exists($plugin){
    	return file_exists("plugins/".$plugin);
    }


	public function __construct($root_dir = null){	

		if($root_dir!==null && !is_array($root_dir)){

			$eloquent = self::where('root_dir',$root_dir)->get();

			if($eloquent!=null){

				$attributes = $eloquent->toArray();

				!isset($attributes[0])? : $attributes = $attributes[0];

				$this->fill($attributes);

			}
		}

		isset($this->root_dir) ? : $this->root_dir = $root_dir;			
	}


    public function isInstalled(){
    	$result = self::where('root_dir',$this->root_dir)->get();

    	return !$result->isEmpty();
    }

    public function isActive(){
    	return $this->active==1;
    }


	public function getConfig($config, $default = NULL){

		isset($this->config)? : $this->config = file_exists($this->getPath()."config.php")? require($this->getPath()."config.php") : NULL;

		return isset($this->config[$config])? $this->config[$config]: $default;
	}

	public function getName(){
		return $this->getInfo('name')==NULL? $this->root_dir : $this->getInfo('name');
	}


	public function getPath(){
		return 'plugins'.DIRECTORY_SEPARATOR.$this->root_dir.DIRECTORY_SEPARATOR;
	}


	public function getIcon(){
		return file_exists($this->getPath()."icon.jpg")? $this->getPath()."icon.jpg" : 'resources/images/icons/plugin.png';
	}

	public function getInfo($info){

		isset($this->info)? : $this->info = file_exists($this->getPath()."plugin_info.xml")? simplexml_load_file($this->getPath()."plugin_info.xml") : NULL;

		return isset($this->info->{$info})? $this->info->{$info}: NULL;
	}

	public function getShortCode(){
		return str_slug($this->root_dir,"_");
	}

	public function getRegisterClass(){
		return "\Plugin\\".$this->root_dir."\Register";
	}

	public function getRegister($register,$default = null){

		$plugin_namespace = $this->getRegisterClass();

		if(method_exists($plugin_namespace,$register)){
            return $plugin_namespace::$register();
        }

        return $default;
	}


}
