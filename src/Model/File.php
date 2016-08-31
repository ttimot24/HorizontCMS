<?php


class File{

	var $name;
	var $extension;
	var $creation_time;
	var $size;

	function __construct($file_path){

		$this->name = basename($file_path);
		$this->extension = pathinfo($file_path, PATHINFO_EXTENSION);
		$this->creation_time = filectime($file_path);
		$this->size = filesize($file_path);

	}



	public static function search($word){

		if(!isset($word) || strlen($word)==0){
			return NULL;
		}

		$_SYSTEM = new System();

		$finds = array();

			  $all_dir = $_SYSTEM->get_dir_map();

			  foreach($all_dir as $dir){

			    if(strpos($dir,$word)>0){
			          array_push($finds, $dir);
			        }

			    $all_files = scandir($dir);

			    foreach(array_slice($all_files,2) as $file){
			        if(strpos($file,$word)>-1){
			          array_push($finds, $dir."/".$file);
			        }

			    }
			}

		return $finds;
	}











}





?>