<?php 


class UserController extends Controller{

	function before(){

		$this->offset = 100;

		$this->view->js('resources/scripts/ctrlplus.js');

	}


	function index(){

		$this->page(array(1));
		
	}

	function page($args){


		$start = ($args[0]-1) * $this->offset;

		$number_of_users = $this->model->countAll();

		$number_of_users > $this->offset? $bool=TRUE : $bool=FALSE; 

		$pages_number = ceil($number_of_users/$this->offset);


		$this->view->title = "Users";
		$this->view->render("user/index",array(
											   'users' => $this->model->get_all(array($start,$this->offset)),
											   'active' => count($this->model->get_active_users()),
											   'number' => $number_of_users,
												'show_pagination' => $bool,
												'page' => $args[0],
												'pages_number' => $pages_number,
											   ));

	}



	function view($id){


		$current_user = $this->model->get_instance($id[0]);

		$this->view->title = "View user";
		$this->view->render("user/view",array('instance' => $current_user,
											  'all' => $this->model->get_all(),
											  'blogposts' => $current_user->get_user_blogposts(),
											  'comments' => $current_user->get_comments(),
											   ));
	}





	function add(){

		if($this->request->typeEquals('POST')){

			if($this->request->existsPost('password') && $this->request->getPost('password')!=""){
				//$_POST['password'] = Security::password_encrypt($_POST['password']);
				$this->request->setPost('password', Security::password_encrypt($this->request->getPost('password')));
			}

			//$_POST['image'] = isset($_FILES['up_file'])? strtolower($_FILES['up_file']['name']) : "";
			$this->request->setPost('image',isset($_FILES['up_file'])? strtolower($_FILES['up_file']['name']) : "");

			$this->model->construct_by_array($this->request->getArray('POST'));
			$this->model->setValue('active',1);
			$this->model->setValue('visits',0);
			$this->model->setValue('session',0);
			$this->model->setValue('reg_date',time());

			$query_status = $this->model->save();

			$query_status->code==0?
								$this->view->message->setMessage('success','Successfully added a new user'):
								$this->view->message->setMessage('error',$query_status->message);



			if(isset($_FILES['up_file']['name']) && $_FILES['up_file']['name']!=""){

				$status = System::upload_file(Storage::$path.'/images/users/',$_FILES['up_file']);

				if($status['code']){
					System::create_thumb(Storage::$path."/images/users/",$_FILES['up_file']['name']);
					$this->view->message->setMessage('success','Successfully uploaded an image!');
				}
				else{
					$this->view->message->setMessage('error','Image upload failed!');
				}
			}

			if($query_status->code==0){
				$this->redirect("admin/user/update/".$this->model->connection->lastInsertId());
				return;
			}
		}



		$this->load_model('UserRank','user_ranks');


		$this->view->title = "Add user";
		$this->view->render("user/new",[
										'ranks' => $this->user_ranks->get_all(),
										]);
	}






	function update($args){


		if($this->request->typeEquals('POST')){


			if($this->request->existsPost('password') && $this->request->getPost('password')!=""){
				$this->request->setPost('password', Security::password_encrypt($this->request->getPost('password')));
			}

			
			if(isset($_FILES['up_file']['name'])  && $_FILES['up_file']['name']!=""){
				//$_POST['image'] = strtolower($_FILES['up_file']['name']);
				$this->request->setPost('image',strtolower($_FILES['up_file']['name']));

			}

			$this->model->construct_by_array($this->request->getArray('POST'));
			$query_status = $this->model->updatex();

			//$query_status = $this->model->update($_POST);

			$query_status->code==0?
								$this->view->message->setMessage('success','Successfully updated the user'):
								$this->view->message->setMessage('error',$query_status->message);


			if(isset($_FILES['up_file']['name']) && $_FILES['up_file']['name']!=""){

				$status = System::upload_file(Storage::$path.'/images/users/',$_FILES['up_file']);

				if($status['code']){
					System::create_thumb(Storage::$path."/images/users/",$_FILES['up_file']['name']);
					$this->view->message->setMessage('success','Successfully uploaded an image!');
				}
				else{
					$this->view->message->setMessage('error','Image upload failed!');
				}
			}




		}





		$this->load_model('UserRank','user_ranks');

		$this->view->title = "Update user";
		$this->view->render("user/update",[
											'instance' => $this->model->get_instance($args[0]),
											'ranks' => $this->user_ranks->get_all(),
											]);
	}





	function delete($args){

		if($args[0]!=1){
			$query_status = $this->model->delete($args[0]);
		
		$query_status->code==0?
							 $this->view->message->setMessage('success','Successfully deleted the user'):
							 $this->view->message->setMessage('error',$query_status->message);

		}
		else{
			 $this->view->message->setMessage('error','You can not remove the main administrator!');
		}

		$this->redirect("admin/user");
		exit;
	}



	public function ajaxGetNewUser(){

		$all = $this->model->get_all();
		$last_user = end($all);

		$seconds = time() - $last_user->reg_date;

	//	if($seconds < 10){
			echo "<a href='admin/user/view/".$last_user->id."'>".$last_user->username."</a>";
	//	}
	}




	public function ajaxAuthenticate(){

		$user = $this->model->get_instance_by_username(Session::get('username'));

		if($user->authenticate($_POST['pwd'])){
			echo "TRUE";
		}
		else{
			echo "FALSE";
		}

	}








}




?>