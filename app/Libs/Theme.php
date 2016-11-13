<?php 

namespace App\Libs;

class Theme{


	public function __construct($root_dir){
		$this->root_dir = $root_dir;		
		$this->info = file_exists($this->getPath()."theme_info.xml")? simplexml_load_file($this->getPath()."theme_info.xml") : NULL;

		$this->config = file_exists($this->getPath()."config.php")? require($this->getPath()."config.php") : NULL;


	}


	public function templates(){
	
		if(file_exists('themes'.DIRECTORY_SEPARATOR.$this->root_dir.DIRECTORY_SEPARATOR.'page_templates')){
			return array_slice(scandir('themes'.DIRECTORY_SEPARATOR.$this->root_dir.DIRECTORY_SEPARATOR.'page_templates'),2);
		}else{
			new \Exception('Couldn\'t render the theme!');
		}
	
		return [];
	}

	public function getConfig($config){
		return isset($this->config[$config])? $this->config[$config]: NULL;
	}

	public function getName(){
		return $this->getInfo('name')==NULL? $this->root_dir : $this->getInfo('name');
	}


	public function getPath(){
		return 'themes'.DIRECTORY_SEPARATOR.$this->root_dir.DIRECTORY_SEPARATOR;
	}


	public function getImage(){
		return $this->getPath()."preview.jpg";
	}

	public function getInfo($info){
		return isset($this->info->{$info})? $this->info->{$info}: NULL;
	}

	public function has404Template(){
		return (file_exists($this->getPath()."404.blade.php") || file_exists($this->getPath()."404.php"));
	}

	public function hasWebsiteDownTemplate(){
		return (file_exists($this->getPath()."website_down.blade.php") || file_exists($this->getPath()."website_down.php"));
	}

}