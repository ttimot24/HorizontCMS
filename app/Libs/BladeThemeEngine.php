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


	public function render(array $data){

		if(strpos( $this->page_template, "default" ) === false ){
			\View::addNamespace('theme', 'themes'.DIRECTORY_SEPARATOR.$this->theme->root_dir);

			return view('theme::'.$this->page_template,$data);
		}else{
			return view($this->page_template);
		}

	}



}