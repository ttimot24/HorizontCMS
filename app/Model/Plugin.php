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
    	$result = self::where('root_dir',$this->root_dir)->get();

    	return ($this->isInstalled() && $this->active==1);
    }

	public function getConfig($config, $default = NULL){

		isset($this->config)? : $this->config = file_exists($this->getPath()."config.php")? require($this->getPath()."config.php") : NULL;

		return isset($this->config[$config])? $this->config[$config]: $default;
	}

	public function getName(){
		return $this->getInfo('name')==NULL? $this->root_dir : $this->getInfo('name');
	}

	public function getNamespaceFor($for){
		return "\Plugin\\".$this->root_dir."\\App\\".ucfirst($for)."\\";
	}

	public function getSlug(){
		return namespace_to_slug($this->root_dir);
	}

	public function getPath(){
		return 'plugins'.DIRECTORY_SEPARATOR.$this->root_dir.DIRECTORY_SEPARATOR;
	}

	public function getDatabaseFilesPath(){

		$path_to_db = $this->getPath().'database';

		if(file_exists($path_to_db) && is_dir($path_to_db)){
			return $this->getPath().'database';
		}
	 
		return NULL;
	}


	public function getIcon(){
		return file_exists($this->getPath()."icon.jpg")? $this->getPath()."icon.jpg" : 'resources/images/icons/plugin.png';
	}

	public function getInfo($info){

		if(!isset($this->info)){

			$file_without_extension = $this->getPath()."plugin_info";
		
			if(file_exists($file_without_extension.".yml") && class_exists('\Symfony\Component\Yaml\Yaml')){
				$this->info = (object) \Symfony\Component\Yaml\Yaml::parse(
																	file_get_contents($file_without_extension.".yml"),
																	\Symfony\Component\Yaml\Yaml::PARSE_OBJECT
																  );
			}else if(file_exists($file_without_extension.".json")){
				$this->info = json_decode(file_get_contents($file_without_extension.".json"));
			}else if(file_exists($file_without_extension.".xml")){
				$this->info = simplexml_load_file($file_without_extension.".xml");
			}else{
				$this->info = NULL;
			}


		}

		return isset($this->info->{$info})? $this->info->{$info}: NULL;
	}

	public function getShortCode(){
		return "{[".$this->root_dir."]}";
	}

	public function getRegisterClass(){
		return "\Plugin\\".$this->root_dir."\Register";
	}

	public function hasRegister($register){
		return method_exists($this->getRegisterClass(),$register);
	}


	public function getRegister($register,$default = null){

		$plugin_namespace = $this->getRegisterClass();

		if($this->hasRegister($register)){
            return $plugin_namespace::$register();
        }

        return $default;
	}


	public function getRequirements(){
		return $this->getInfo('requires');
	}

	public function getRequiredCoreVersion(){
		return isset($this->getInfo('requires')->core)? $this->getInfo('requires')->core : NULL;
	}

	public function isCompatibleWithCore(){
		
		return \Composer\Semver\Comparator::greaterThanOrEqualTo(\App\Model\SystemUpgrade::getCurrentVersion()->version,$this->getRequiredCoreVersion());
	}


}
