<?php 

class HeaderimagesController extends Controller{


	public function before(){

		$this->load_model('HeaderImage','header_image');

	}



	public function index(){



		$slider = $this->header_image->get_all();
		$dirs = $this->header_image->get_all_from_dir();

		//$available_array = array_diff($dirs,$slider);

		$this->view->title = "Header Images";
		$this->view->render("files/header_images",[
													'slider_images' => $slider,
													'dirs' => $dirs,
													]);
	}





	public function upload(){

		System::upload_file(Storage::$path."/images/header_images/",$_FILES['up_file']);

		$this->redirect_to_self();

	}



	public function delete(array $args){

		if(file_exists(Storage::$path."/images/header_images/" .$args[0])){
			unlink(Storage::$path."/images/header_images/" .$args[0]);
		}


		$this->redirect_to_self();
	}



	public function addtoslider(array $args){

		$this->header_image->setValue('title','default');
		$this->header_image->setValue('image',$args[0]);

		$this->header_image->save();

		$this->redirect_to_self();
	}

	public function getoffslider(array $args){
		$this->header_image->delete($args[0]);
	
		$this->redirect_to_self();
	}



}



?>