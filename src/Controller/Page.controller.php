<?php 


class PageController extends Controller{

	public function before(){


		 $this->load_model('Theme');

		 $this->view->js('http://cdn.ckeditor.com/4.5.4/full/ckeditor.js');
		 $this->view->js('resources/scripts/ctrlplus.js');
		 $this->view->css('resources/assets/checkboxmaster/build.css');

		 $this->view->js(VIEW_DIR.'/pages/pages.script.js');
	}


	public function index(){

		$this->view->title = "Pages"; 
		$this->view->render("pages/index",[
											'all' => $this->model->get_all(),
											'visible' => $this->model->get_visible_pages(),
											'welcome_page' => $this->model->get_welcome_page(),
											]);
	}





	public function create(){


		if($this->request->typeEquals('POST')){


			!isset($_FILES['up_file']['name'])? : $this->request->setPost('image',strtolower($_FILES['up_file']['name']));

			$this->model->construct_by_array($this->request->getArray('POST'));
			$this->model->setValue('queue',0);

			$query_status = $this->model->save();


			$query_status->code==00000?
									$this->view->message->setMessage('success','Successfully created a new page!'):
									$this->view->message->setMessage('error',$query_status->message);

			

			if(isset($_FILES['up_file']['name']) && $_FILES['up_file']['name']!=""){

				$status = System::upload_file(Storage::$path.'/images/pages/',$_FILES['up_file']);

				if($status['code']){
					System::create_thumb(Storage::$path."/images/pages/",$_FILES['up_file']['name']);
					$this->view->message->setMessage('success','Successfully uploaded an image!');
				}
				else{
					$this->view->message->setMessage('error','Image upload failed!');
				}
			}



			$this->redirect("admin/page/update/".$this->model->connection->lastInsertId());
			exit;
		}



		$this->view->title = "New page"; 
		$this->view->render("pages/new",[
										'all' => $this->model->get_all(),
										'page_templates' => $this->theme->get_active_theme()->get_page_templates(),
										'page_images' => Storage::findAllIn('images/pages'),
										'domain' => $_SERVER['SERVER_NAME'],
										]);


	}



	public function update(array $args){

		if($this->request->typeEquals('POST')){


			if(isset($_FILES['up_file']['name'])){
				$this->request->setPost('image',strtolower($_FILES['up_file']['name']));
			}

			$this->model->construct_by_array($this->request->getArray('POST'));

			$query_status = $this->model->updatex();

			$query_status->code==00000?
									$this->view->message->setMessage('success','Successfully updated the page!'):
									$this->view->message->setMessage('error',$query_status->message);


			if(isset($_FILES['up_file']['name']) && $_FILES['up_file']['name']!=""){

				$status = System::upload_file(Storage::$path.'/images/pages/',$_FILES['up_file']);

				if($status['code']){
					System::create_thumb(Storage::$path."/images/pages/",$_FILES['up_file']['name']);
					$this->view->message->setMessage('success','Successfully uploaded an image!');
				}
				else{
					$this->view->message->setMessage('error','Image upload failed!');
				}
			}




		}




		$this->view->title = "Update page";
		$this->view->render("pages/update",[
											'instance' =>$this->model->get_instance($args[0]),
											'all' => $this->model->get_all(),
											'page_templates' => $this->theme->get_active_theme()->get_page_templates(),
											'domain' => $_SERVER['SERVER_NAME'],
											]);
	}





	public function delete($args){

		$image = $this->model->get_instance($args[0])->image;
		$query_status = $this->model->delete($args[0]);

		if(isset($image) && $image!=""){
			@unlink("images/pages/".$image);
			@unlink("images/pages/thumbs/".$image);
		}

		$query_status->code==00000?
									$this->view->message->setMessage('success','Successfully deleted the page!'):
									$this->view->message->setMessage('error',$query_status->message);


		$this->redirect_to_self();
	}





	public function home($args){


		$status = $this->model->connection->query("UPDATE ".PREFIX."settings SET value='".$args[0]."' WHERE setting='home_page'");

		$status?
				$this->view->message->setMessage('success','Successfully selected the HomePage!'):
				$this->view->message->setMessage('error',System::$connection->error);


		$this->redirect_to_self();
	}



}



?>