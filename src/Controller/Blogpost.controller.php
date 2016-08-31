<?php 

class BlogpostController extends Controller{


	public function before(){

		$this->load_model('BlogpostCategory','category');
		$this->load_model('BlogpostComment','comment');

		$this->offset = 15;	

		$this->view->js('http://cdn.ckeditor.com/4.5.4/full/ckeditor.js');
		$this->view->js('resources/scripts/ctrlplus.js');
	
	}


	public function index(){

		$this->page([1]);
	}

	public function page($args){

		

		$number_of_posts = $this->model->countAll();

		$number_of_posts > $this->offset? $bool=TRUE : $bool=FALSE; 

		$pages_number = ceil($number_of_posts/$this->offset);


		$start = $number_of_posts - ($this->offset * $args[0]);

		if($start<0){
			$this->offset = $start + $this->offset;
			$start = 0;
		}

		$this->view->title = "All blogposts";
		$this->view->render("blogposts/index",[
												'all' => $this->model->get_all_blogpost([$start,$this->offset]),
												'number' => $number_of_posts,
												'show_pagination' => $bool,
												'page' => $args[0],
												'pages_number' => $pages_number,
											   ]);
	}

	public function category(){

		$this->redirect("admin/category/index");
	}


	public function view(array $args){

		$instance = $this->model->get_instance($args[0]);


		$this->view->title = "View blogpost";
		$this->view->render("blogposts/view",array('instance' => $instance,
													'all' => $this->model->get_all(),
													'comments' =>  $instance->get_comments(),

													));

	}


	public function newpost(){

		if($this->request->typeEquals('POST')){
	
	//		$_POST['image'] = isset($_FILES['up_file'])? strtolower($_FILES['up_file']['name']) : "";
			$this->request->setPost('image',isset($_FILES['up_file'])? strtolower($_FILES['up_file']['name']) : "");

			$this->model->construct_by_array($this->request->getArray('POST'));
			$this->model->setValue('author',Session::get('id'));


			if($this->request->getPost('pubdate')==""){
				$this->model->setValue('date',time());
			}
			else{
				$this->model->setValue('date',strtotime($this->request->getPost('pubdate')));
			}

			$query_status = $this->model->save();


			$query_status->code==00000? 
						$this->view->message->setMessage('success','Successfully added a new post.') : 
						$this->view->message->setMessage('error','<u>' .$query_status->message."</u>");


			if(isset($_FILES['up_file']['name']) && $_FILES['up_file']['name']!=""){

				$status = System::upload_file(Storage::$path.'/images/blogposts/',$_FILES['up_file']);

				if($status['code']){
					System::create_thumb(Storage::$path."/images/blogposts/",$_FILES['up_file']['name']);
					$this->view->message->setMessage('success','Successfully uploaded an image!');
				}
				else{
					$this->view->message->setMessage('error','Image upload failed!');
				}
			}


			$this->redirect("admin/blogpost/update/".$this->model->connection->lastInsertId());
			return;
		}



/*
		$this->view->css('resources/assets/datetimepicker/build/jquery.datetimepicker.min.css');
		$this->view->js('resources/assets/datetimepicker/build/jquery.datetimepicker.full.js');*/


		$this->view->title = "New blogpost";
		$this->view->render("blogposts/new",['categories' => $this->category->get_all()]);
	}




	public function update(array $args){

		if($this->request->typeEquals('POST')){

			if(isset($_FILES['up_file']['name']) && $_FILES['up_file']['name']!=""){
				$this->request->setPost('image',strtolower($_FILES['up_file']['name']));
			}


			$this->model->construct_by_array($this->request->getArray('POST'));

			$query_status = $this->model->updatex();

			//$query_status = $this->model->update($_POST);

			$query_status->code==00000? 
						$this->view->message->setMessage('success','Successfully updated this post.') : 
						$this->view->message->setMessage('error',$query_status->message);




			if(isset($_FILES['up_file']['name']) && $_FILES['up_file']['name']!=""){

				$status = System::upload_file(Storage::$path.'/images/blogposts/',$_FILES['up_file']);

				if($status['code']){
					System::create_thumb(Storage::$path."/images/blogposts/",$_FILES['up_file']['name']);
					$this->view->message->setMessage('success','Successfully uploaded an image!');
				}
				else{
					$this->view->message->setMessage('error','Image upload failed!');
				}
			}




		}


		$this->view->title = "Update blogpost";

		$this->view->render("blogposts/update", array('instance' => $this->model->get_instance($args[0]),'categories' => $this->category->get_all()));
	}



	public function delete(array $args){

		$image = $this->model->get_instance($args[0])->image;
		$query_status = $this->model->delete($args[0]);

		if(isset($image) && $image!="" && file_exists(Storage::$path."/images/blogposts/".$image)){
			unlink(Storage::$path."/images/blogposts/".$image);
			@unlink(Storage::$path."/images/blogposts/thumbs/".$image);
			/*Storage::remove("images/blogposts/".$image);
			Storage::remove("images/blogposts/thumbs/".$image);*/
		}

		$query_status->code==00000?
									$this->view->message->setMessage('success','Successfully deleted the blogpost!'):
									$this->view->message->setMessage('error',$query_status->message);	



		$this->redirect("admin/blogpost");
		return;
	}


	public function newcomment(){


		$this->comment->construct_by_array($this->request->getArray('POST'));
		$this->comment->setValue('user_id',Session::get('id'));
		$this->comment->setValue('date',time());

		$query_status = $this->comment->save();

		$query_status->code==0?
									$this->view->message->setMessage('success','Successfully commented this post!'):
									$this->view->message->setMessage('error',$query_status->message);

		$this->redirect_to_self();
	}




	public function deletecomment(array $args){

		$query_status = $this->comment->delete($args[0]);

		$query_status->code==0?
									$this->view->message->setMessage('success','Successfully deleted the comment!'):
									$this->view->message->setMessage('error',$query_status->message);	


		
		$this->redirect_to_self();
	}




}


?>