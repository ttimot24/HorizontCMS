<?php 

namespace App\Libs;

class BladeThemeEngine{

	protected $theme;
	protected $page_template = 'index';
	public $request;

	public function __construct(\Illuminate\Http\Request $request){
		$this->request = $request;
	}

	public function getTheme(){
		return $this->theme;
	}

	public function setTheme(\App\Libs\Theme $theme){
		$this->theme = $theme;
	}

	public function pageTemplate($page_template){
		$this->page_template = $page_template;
	}

	public function defaultTemplateExists($template){
		return file_exists($this->theme->getPath().$template.'.blade.php'); 
	}

	public function templateExists($template){
		return file_exists($this->theme->getPath()."page_templates".DIRECTORY_SEPARATOR.$template.'.blade.php'); 
	}


	public function render(array $data){

		if(strpos( $this->page_template, "default" ) === false ){ //Not default view
			\View::addNamespace('theme', 'themes'.DIRECTORY_SEPARATOR.$this->theme->root_dir);

			return view('theme::'.$this->page_template,$data);
		}else{
			return view($this->page_template);
		}

	}


	public function runScript($script_name){

		dd($this->theme->config[$script_name]);
		return call_user_func($this->theme->getConfig($script_name));
	}


	public function render404(){
		
		if($this->theme->has404Template()){
			$this->page_template = "404";
		}else{
			$this->page_template = "default.404";
		}

	}

	public function renderWebsiteDown(){
		if($this->theme->hasWebsiteDownTemplate()){
			$this->page_template = "website_down";
		}else{
			$this->page_template = "default.website_down";
		}
	}



}