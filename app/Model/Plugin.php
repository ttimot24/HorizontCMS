<?php

namespace App\Model;

use \App\Libs\Model;

class Plugin extends Model
{
    public $timestamps = false;

    public static function exists($plugin){
    	return file_exists("plugins/".$plugin);
    }


	public function __construct($root_dir){
		$this->root_dir = $root_dir;		
		$this->info = file_exists($this->getPath()."plugin_info.xml")? simplexml_load_file($this->getPath()."plugin_info.xml") : NULL;

		$this->config = file_exists($this->getPath()."config.php")? require($this->getPath()."config.php") : NULL;


	}


	public function getConfig($config, $default = NULL){
		return isset($this->config[$config])? $this->config[$config]: $default;
	}

	public function getName(){
		return $this->getInfo('name')==NULL? $this->root_dir : $this->getInfo('name');
	}


	public function getPath(){
		return 'plugins'.DIRECTORY_SEPARATOR.$this->root_dir.DIRECTORY_SEPARATOR;
	}


	public function getIcon(){
		return $this->getPath()."icon.jpg";
	}

	public function getInfo($info){
		return isset($this->info->{$info})? $this->info->{$info}: NULL;
	}

	public function getShortCode(){
		return str_slug($this->root_dir,"_");
	}

	public function getWidget(){
		return (file_exists($this->getPath()."index.php"))? file_get_contents($this->getPath()."index.php") : /*NULL*/ "";
	}


}
