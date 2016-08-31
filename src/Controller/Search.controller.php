<?php 

class SearchController extends Controller{


	function before(){

		$this->load_model('Blogpost');
		$this->load_model('User');
		$this->load_model('Page');

	}


	public function index(){

		if(!$this->request->existsPost('search')){
			$this->redirect("admin/dashboard/index");
			exit;
		}



	$this->view->title="Search for '" .$this->request->getPost('search')."'";
	$this->view->render("search/index",[
										'search_for' => $this->request->getPost('search'),
										'blogposts' => 	$this->blogpost->search($this->request->getPost('search')),
										'users' => $this->user->search($this->request->getPost('search')),
										'pages' => $this->page->search($this->request->getPost('search')),
										'files' => [],

										]);
	

	}






}



?>