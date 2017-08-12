<?php 

namespace App\Libs;


class DotEnvGenerator{


	private $content = array();
	private $path = "";
	private $file = ".env";


	public function setPath($path){
		$this->path = $path."/";
	}


	public function addEnvVar($var,$val){
		$this->content[strtoupper($var)]=$val; 
	}

	public function getEnvVars(){
		return $this->content;
	}

	public function generate(){

		$file_content = "";

		foreach($this->content as $key => $val){
			$file_content .= strtoupper($key)."=".$val.PHP_EOL;
		}

		return file_put_contents($this->path.$this->file,$file_content);
	}



}