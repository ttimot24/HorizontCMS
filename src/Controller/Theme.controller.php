<?php 


class ThemeController extends Controller{


	public function before(){


		$this->load_model('Theme','themes');

	}


	public function index(){

		$themes = $this->themes->get_all();


		$this->view->title = "Themes";
		$this->view->render("theme/index",[
											'all_theme' => $themes, 
											'active' => $this->themes->get_active_theme(),
											]);
	}


	public function set($args){

		if(isset($args[0])){
			$this->themes->set($args[0]);
		}


		$this->redirect_to_self();
	}


	public function upload(){

		$status = System::upload_file("themes/",$_FILES['up_file']);

		$zip = new ZipArchive;
		$res = $zip->open('themes/'.$_FILES['up_file']['name'][0]);
		if ($res === TRUE) {
		  $zip->extractTo('themes/');
		  $zip->close();
		  unlink('themes/'.$_FILES['up_file']['name'][0]);
		} 


		isset($status['code'])?
					$this->view->message->setMessage('success','Successfully upladed the theme'):
					$this->view->message->setMessage('error','An error occured while uploading the theme!');


		$this->redirect_to_self();
	}



	public function delete($args){

		$status = System::remove_recursively("themes/".$args[0]);

		$status?
				$this->view->message->setMessage('success',"Successfully removed the theme"):
				$this->view->message->setMessage('error',"Something went wrong!");


		$this->redirect_to_self();
	}



	public function preview($args){

		Website::$_THEME_PATH = "themes/".$args[0];

		$system = new System();

		Website::$_SETTINGS = $system->settings;
		Website::$_SETTINGS->theme = $args[0];

		//chdir("../");

		include("themes/".$args[0]."/header.php");
		include("themes/".$args[0]."/index.php");
		include("themes/".$args[0]."/footer.php");

	}




}




?>