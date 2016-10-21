<?php 

namespace App\Libs;

class BladeThemeEngine{

	protected $theme;


	public function addTheme(\App\Libs\Theme $theme){
		$this->theme = $theme;
	}


	public function render(){

		\View::addNamespace('theme', 'themes'.DIRECTORY_SEPARATOR.$this->theme->root_dir);

		return view('theme::index',[
									'_THEME_PATH' => 'themes'.DIRECTORY_SEPARATOR.$this->theme->root_dir.DIRECTORY_SEPARATOR,
									]);

	}



}