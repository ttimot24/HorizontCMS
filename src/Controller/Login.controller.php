<?php 


class LoginController extends Controller{



	public function index(){

		$this->view->title = "HorizontCMS v".$this->config['version'];

		if(Session::get('username')!=NULL){
			$this->redirect("admin/dashboard/index");
		}
		else{

	
			$this->view->render("login/index",[
											'admin_logo' => $this->system->get_admin_logo(),
												]);
		}
	}


	public function authenticate(){

		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');


		$this->load_model('User');
		$user = $this->user->get_instance_by_username($username);

		if($user && $user->has_permission('admin_area')){
		
			if($user->authenticate($password)){
				Session::set('id',$user->id);
				Session::set('username',$user->username);
				Session::set('permission',$user->rank);
			}
			else{
				$this->view->message->setMessage('error',"Username or password doesn't match!");
			}
	
		}else{
			$this->view->message->setMessage('error',"You don't have permission to this page!");
		}


		$this->redirect_to_self();
	}


	public function logout(){

		Security::secure_session_destroy();


		$this->redirect("admin/login");
		//$this->redirect_to_self();
	}





}




?>