<?php 

class GalleryController extends Controller{


	public function before(){

		Storage::create('dir','images/gallery');


	}



	public function index(){

		$this->view->title = "Gallery";
		$this->view->render("files/gallery",[
											//'galleries' => Storage::findAllIn("images/gallery"),
											'galleries' => $this->model->get_all(),

											]);
	}


	public function open($args){

		$instance = $this->model->get_instance_by_directory($args[0]);


		$images = scandir(Storage::$path."/images/gallery/".$instance->directory);

		$this->view->title = "Gallery";
		$this->view->render("files/opened_gallery",[
													'gallery_name' => $instance->name,
													'current_dir' => $instance->directory,
													'images' => array_slice($images,2),
													'count' => count($images)-2,
													]);

	}


	public function newgallery(){

		$gallery_name = $this->request->getPost('new_gallery');

		$dir_name = $this->model->clean_dir_name($gallery_name);



		if(mkdir(Storage::$path."/images/gallery/".$dir_name)){

			$this->model->setValue('name',$gallery_name);
			$this->model->setValue('directory',$dir_name);
			$this->model->setValue('active',1);

			$status = $this->model->save();

			if($status->code==00000){
				$this->view->message->setMessage('success','New gallery succesfully created');
			}
			else{
			 $error = error_get_last();
			 $this->view->message->setMessage('error',$error['message']);
			}
		}else{
			 $this->view->message->setMessage('error','Could not create gallery directory!');
		}




		$this->redirect_to_self();
	}


	public function delete($args){

		if(count(scandir(Storage::$path."/images/gallery/" .$args[0]))>2){
		
			$files = scandir(Storage::$path."/images/gallery/" .$args[0]);

			foreach ($files as $img) {
				unlink(Storage::$path."/images/gallery/" .$args[0] ."/" .$img);
			}
		}




		$status = rmdir(Storage::$path."/images/gallery/" .$args[0]);
		$instance = $this->model->get_instance_by_directory($args[0]);
		$status_db = $this->model->delete($instance->id);

		if($status && $status_db->code==00000){
			$this->view->message->setMessage('success','Successfully deleted the gallery');
		}
		else{
			 $error = error_get_last();
			 $this->view->message->setMessage('error',$error['message']);
		}


		$this->redirect_to_self();
	}




	public function rename($args){

		$instance = $this->model->get_instance_by_directory($args[0]);


		$status = rename(Storage::$path."/images/gallery/".$args[0],Storage::$path."/images/gallery/".$this->model->clean_dir_name($this->request->getPost('new_name')));

		if($status){
			$instance->setValue('name',$this->request->getPost('new_name'));
			$instance->setValue('directory',$this->model->clean_dir_name($this->request->getPost('new_name')));
			var_dump($instance->updatex());
			$this->view->message->setMessage('success','Successfully renamed the gallery');
		}
		else{
			 $error = error_get_last();
			 $this->view->message->setMessage('error',$error['message']);
		}


		$this->redirect_to_self();

	}



	public function upload($args){


		$status = System::upload_file(Storage::$path."/images/gallery/".$args[0]."/",$_FILES['up_file']);

		if($status){
			$this->view->message->setMessage('success','Successfully renamed the gallery');
		}
		else{
			 $error = error_get_last();
			 $this->view->message->setMessage('error',$error['message']);
		}

		$this->redirect_to_self();

	}


	public function deleteselected(){

		foreach($_POST['delete_img'] as $each){
			$status = unlink(Storage::$path."/images/gallery/" .$this->request->getPost('dir')."/" .$each);
		}

		if($status){
			$this->view->message->setMessage('success','Successfully deleted the images');
		}
		else{
			 $error = error_get_last();
			 $this->view->message->setMessage('error',$error['message']);
		}


		$this->redirect_to_self();
	}


}


?>