<?php 

class ErrorController extends Controller{

	public function __construct($message=NULL){
		parent::__construct(new Request($_GET,$_POST));

		$this->view->render("error/index",[
											'message' => $message,
											]);

	}



}


?>