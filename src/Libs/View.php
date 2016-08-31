<?php 

class View implements IViewInterface{

	public $css;
	public $js;
	public $charset;

	public $title;
	public $theme;
	public $language;


	public function __construct(Navigation $navigation,$language){
		$configuration = include('core/init.php');

		$this->setLanguage($language);

		$this->message = new Message();

		$this->navigation = $navigation;

		$this->css = $configuration['css'];

		$this->js = $configuration['js'];

		$this->meta = [];

		$this->charset = $configuration['charset'];

	}


	public function render($name,$data = null){

		require VIEW_DIR."header.php";

		if(Session::get('username')!=null){

			require(VIEW_DIR."default/sitelinks.php");

			require(VIEW_DIR."default/messages.php");
		}

		if(file_exists( VIEW_DIR .$name .".php")){
			require VIEW_DIR .$name .".php";
		}
		else{
			require VIEW_DIR."framework/error.php";
			//throw new Error(16,"No view file!");
		}
	
		require VIEW_DIR."footer.php";
	}



	public function renderPartial($name,$data = null){

		require VIEW_DIR."header.php";

		if(file_exists(VIEW_DIR .$name .".php")){
			require_once(VIEW_DIR .$name .".php");
		}
		else{
			throw new Error(12,"No view file: ".$name);
		}
	}


	public function setLanguage($language){
		$this->language = $language;
	}


	public function setTitle($title){
		$this->title = $title;
	}	


	public function css($link){
		$this->css[] = $link;
	}

	public function js($link){
		$this->js[] = $link;
	}

	public function meta($name,$content){
		$this->meta[] = ['name'=>$name,'content' => $content];
	}





}


?>