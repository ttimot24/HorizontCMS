<?php 

namespace App\Libs;

class BladeThemeEngine{

	protected $theme;
	protected $page_template = 'index';
	public $request;

	public function __construct(\Illuminate\Http\Request $request){
		$this->request = $request;
	}


	public function addTheme(\App\Libs\Theme $theme){
		$this->theme = $theme;
	}

	public function pageTemplate($page_template){
		$this->page_template = $page_template;
	}


	public function render(){

		\View::addNamespace('theme', 'themes'.DIRECTORY_SEPARATOR.$this->theme->root_dir);

		return view('theme::page_templates.'.$this->page_template,[
																	'_THEME_PATH' => 'themes'.DIRECTORY_SEPARATOR.$this->theme->root_dir.DIRECTORY_SEPARATOR,
																	]);

	}



}