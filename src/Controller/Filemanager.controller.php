<?php 

class FileManagerController extends Controller{

	public function before(){

		$this->default_folder = Storage::$path."/";
	}



	public function index(){


		$selected_dir = scandir($this->default_folder);	


		$files = array();

		foreach($selected_dir as $each){
			 array_push($files,new File($this->default_folder.$each));
		}

		$this->view->title = "File manager";
		$this->view->render("files/filemanager",[
											'current_dir' => $this->default_folder,
											'files' => array_slice($files,2),
										   ]);
	}



	public function dir($args=NULL){

		$dir = implode("/",$args);


		$selected_dir = array_slice(scandir($dir),2);	


		$files = array();

		foreach($selected_dir as $each){
			 array_push($files,new File($dir."/".$each));
		}

		$this->view->title = "File manager";
		$this->view->render("files/filemanager",[
											'current_dir' => $dir."/",
											'files' => $files,
										   ]);

	}









}



?>