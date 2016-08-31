<?php 

class Request{

	protected $get = array();
	protected $post = array();


	public function  __construct(array $get, array $post){
		$this->get = $get;
		$this->post = $post;
		$this->requestType = $_SERVER['REQUEST_METHOD'];
	}


	public function getGet($key, $default = ''){
		if(isset($this->get[$key])){
			return $this->get[$key];
		}
		else{
			return $default;
		}
	}


	public function getPost($key, $default = ''){
		if(isset($this->post[$key])){
			return $this->post[$key];
		}
		else{
			return $default;
		}
			
	}


	public function setGet($key,$value){
		$this->get[$key] = $value;
	}

	public function setPost($key,$value){
		$this->post[$key] = $value;
	}

	public function unsetGet($key){
		unset($this->get[$key]);
	}

	public function unsetPost($key){
		unset($this->post[$key]);
	}


	public function existsGet($key){
		return isset($this->get[$key]);
	}

	public function existsPost($key){
		return isset($this->post[$key]);
	}


	public function getArray($type){
		
		$type = strtolower($type);
		
		return $this->$type;
	}

	public function getRequestType(){
		return $this->requestType;
	}

	public function typeEquals($type){
		return $this->requestType == $type;
	}

	public function changeType($type){
		$this->requestType = $type;
	}

}