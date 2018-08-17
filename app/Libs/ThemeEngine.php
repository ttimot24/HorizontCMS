<?php 

namespace App\Libs;

class ThemeEngine{

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
		return file_exists($this->theme->getPath().$template.'.php'); 
	}

	public function templateExists($template){
		return file_exists($this->theme->getPath()."page_templates/".$template.'.php'); 
	}


	public function render(){

		\Website::initalize($this);
		\App\Libs\ShortCode::initalize();
		
		ob_start();

		$this->require_file('header.php');
		$this->require_file('index.php');
		$this->require_file('footer.php');
	
		$output = ob_get_contents();

		ob_end_clean();

		return trim($output);

	}


	private function require_file($file){
		if(file_exists(base_path($this->theme->getPath().$file))){
			require_once(base_path($this->theme->getPath().$file));
		}
	}


	public function runScript($script_name){
		if($this->theme->getConfig($script_name)){
			return call_user_func($this->theme->getConfig($script_name));
		}

		return NULL;
	}

	public function render404(){

		ob_start();
		
		if($this->theme->has404Template()){
			$this->require_file('404.php');
		}else{
			$this->require_file('../../resources/static/404.php');
		}
		
		$output = ob_get_contents();

		ob_end_clean();

		return response(trim($output),404);

	}


	public function renderWebsiteDown(){
		
		ob_start();

		if($this->theme->hasWebsiteDownTemplate()){
			$this->require_file('website_down.php');
		}else{
			$this->require_file('../../resources/static/website_down.php');
		}

		$output = ob_get_contents();

		ob_end_clean();

		return response(trim($output));

	}




}