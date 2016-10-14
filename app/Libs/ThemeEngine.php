<?php 

namespace App\Libs;

class ThemeEngine{

	protected $theme;

	public function render($theme){
		$this->theme = $theme;
		
		$this->require_file('header.php');
		$this->require_file('index.php');
		$this->require_file('footer.php');
	
	}


	private function require_file($file){
		if(file_exists(base_path().DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.$file)){
			require_once(base_path().DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.$file);
		}
	}












}