<?php 

class ErrorReport{

	public $code;
	public $message;


	public function __construct(){

	}

	public function addError(array $error){
		$this->code = (int)$error[0];
		$this->driver_err_code = $error[1];
		$this->message = $error[2];
	}




}




?>