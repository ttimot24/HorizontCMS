<?php 


class Error extends Exception{


	public function __construct($id,$message){

		$this->view = new View(new Navigation([],'english'),'english');
		

		$this->id = $id;
		$this->message = $message;

		$backtrace =  debug_backtrace();

		$this->file = $backtrace[1]['file'];
		$this->line = $backtrace[1]['line'];

	

	}


	public function showException(){
		$this->view->setTitle('Error - HorizontMVC');
		$this->view->renderPartial('framework/error',[
												'message' => $this->message,
												'backtrace' => [
																  'file' => $this->file,
																  'line' => $this->line,
																],
												]);
	}




}