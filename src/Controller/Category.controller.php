<?php


class CategoryController extends Controller{

	public function before(){

		$this->model = new BlogpostCategory();

	}


	public function index(){


		$this->view->title = "Blogpost categories";
		$this->view->render("blogposts/category",[
													'all_category' => $this->model->get_all(),	


													]);
	}



	public function add(){


		$this->model->construct_by_array($this->request->getArray('POST'));

		$query_status = $this->model->save();

		$query_status->code==0?
							$this->view->message->setMessage('success','Successfully added a category.'):
							$this->view->message->setMessage('error',$query_status->message);


		$this->index();
	}

	public function edit($args){

		if($this->request->typeEquals('POST')){
			$query_status = $this->model->update($this->request->getArray('POST'));
		
			$query_status->code == 00000?
							$this->view->message->setMessage('success','Successfully updated the category.'):
							$this->view->message->setMessage('error',$query_status->message);


		}

		$this->view->title = "Update category";
		$this->view->render("blogposts/categoryedit",[
														'instance' => $this->model->get_instance($args[0]),
														]);
	}



	public function delete($args){

		$query_status = $this->model->delete($args[0]);

		$query_status->code == 00000?
							$this->view->message->setMessage('success','Successfully deleted a category.'):
							$this->view->message->setMessage('error',$query_status->message);


		$this->index();
	}





}