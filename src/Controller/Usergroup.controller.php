<?php 


class UserGroupController extends Controller{

	public function before(){

		$this->model = new UserRank();
	}

	public function index(){


		$all_group = $this->model->get_all();

		$this->view->title = "User Groups";
		$this->view->render("user/usergroups",[
												'all_group' => array_reverse($all_group),
												'counted_groups' => count($all_group),
												]);
	}


	public function create(){
		$this->view->title = 'Create User Group';
		$this->view->render("user/usergroup_new");
	}


	public function add(){

		$this->model->construct_by_array($this->request->getArray('POST'));
		$this->model->setValue('name',$this->request->getPost('group_name'));

		$this->request->unsetPost('group_name');

		$this->model->setValue('rights',json_encode($this->request->getArray('POST')));
		$this->model->setValue('permission',0);

		$query_status = $this->model->save();

		$query_status->code==0?
								$this->view->message->setMessage('success','Successfully added a new usergroup <b>'.$this->model->name."</b>"):
								$this->view->message->setMessage('error',$query_status->message);

		$this->redirect('admin/usergroup/index');
	}



	public function update(){

		$user_group = $this->model->get_instance($this->request->getPost('group_id'));
		$this->request->unsetPost('group_id');

		$user_group->setValue('rights',json_encode($this->request->getArray('POST')));

		$query_status = $user_group->updatex();

			$query_status->code==0?
								$this->view->message->setMessage('success','Successfully updated the user rights for <b>'.$user_group->name."</b>"):
								$this->view->message->setMessage('error',$query_status->message);





		
		$this->redirect_to_self();
	}





}