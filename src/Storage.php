<?php 


class Storage{

	public static $path = "storage";

	public static function get($type,$file,$default = ''){

		$type.="s";

		if( $file!="" && file_exists( self::$path.DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR.$file) ){
			return self::$path.DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR.$file;
		}

		return $default;
	}



	public static function create($type,$name){
		if($type=='dir'){ 
			if(!file_exists(self::$path.DIRECTORY_SEPARATOR.$name)){
				return mkdir(self::$path.DIRECTORY_SEPARATOR.$name);
			}
		 }
		 else if($type=='file'){
		 	if(!file_exists(self::$path.DIRECTORY_SEPARATOR.$name)){
		 		return fclose(fopen(self::$path.DIRECTORY_SEPARATOR.$name,"w"));
		 	}
		 }
	}


	public static function remove($path){

			if($path!="" && file_exists(self::$path.DIRECTORY_SEPARATOR.$path)){

			  if(is_file(self::$path.DIRECTORY_SEPARATOR.$path)){
					return unlink(self::$path.DIRECTORY_SEPARATOR.$path);
			  }
			  else{
			  		return rmdir(self::$path.DIRECTORY_SEPARATOR.$path);
			  }

			}
	
	}



	public static function put($type,$file,$name=null){

	}




	public static function findAllIn($dir){
		return array_slice(scandir(self::$path.DIRECTORY_SEPARATOR.$dir),2);
	}


}