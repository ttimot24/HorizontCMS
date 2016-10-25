<?php 

namespace App\Libs;

class ThemeEngine{

	protected $theme;
	public $request;

	public function __construct(\Illuminate\Http\Request $request){
		$this->request = $request;
	}


	public function addTheme(\App\Libs\Theme $theme){
		$this->theme = $theme;
	}


	public function render(){

		\Website::initalize();
		
		$this->require_file('header.php');
		$this->require_file('index.php');
		$this->require_file('footer.php');
	
	}


	private function require_file($file){
		if(file_exists(base_path().DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$this->theme->root_dir.DIRECTORY_SEPARATOR.$file)){
			require_once(base_path().DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$this->theme->root_dir.DIRECTORY_SEPARATOR.$file);
		}
	}












}