<?php 

namespace App\Libs;

class Theme{


	public function __construct($root_dir){
		$this->root_dir = $root_dir;
	}


	public function templates(){
	
		if(file_exists('themes/'.$this->root_dir.'/page_templates')){
			return array_slice(scandir('themes/'.$this->root_dir.'/page_templates'),2);
		}else{
			new \Exception('Couldn\'t render the theme!');
		}
	
		return [];
	}



}