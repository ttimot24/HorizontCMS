<?php 



class System{

	public $settings;
	public static $connection;
	public $current_version;
	public $installed_version;


	public function __construct(){

		$settings_model = new Settings();

		$settings = $settings_model->get_all();

		foreach($settings as $each){

			if(!empty($each->setting)){
				@$this->settings->{$each->setting} = $each->value;
			}
		
		}

	}


	public static function establish_connection(){


		try{
			if(file_exists("core/config.php")){
				self::$connection = new PDO(DB_DRIVER.":host=".SERVER.";dbname=".DATABASE.";charset=".DB_CHARSET, USERNAME, PASSWORD);
				self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			}
		}
		catch(PDOException $e){
			echo $e->getMessage();
		//	throw new Error(2,"Couldn't connect to database! <b>" .$e->getMessage()."</b>");
		}

		return self::$connection;
	}



	public function get_admin_logo(){

		return Storage::get('images/logo',$this->settings->admin_logo,Storage::$path."/images/icons/world.png");

	}

	public function get_admin_background(){


		/*if($this->settings->admin_background!="" && file_exists("storage/images/backgrounds/" .$this->settings->admin_background)){
			return "storage/images/backgrounds/" .$this->settings->admin_background;
		}
		else{
			return "";
		}*/

		return Storage::get('images/background',$this->settings->admin_background,"");
	}


	public static function get_header_images(){
		$header_images = scandir("storage/images/header_images");

		return array_slice($header_images,2);
	}



	public function visits(){

		$result = self::$connection->query("SELECT * FROM ".PREFIX."visits");

		$count = $result->rowCount();

		$result->closeCursor();

		return $count;

	}



	public static function upload_file($path,$file){


		if(!is_array($file['name'])){

				  if($file["error"] > 0) {
				    echo "Return Code: " . $file["error"] . "<br>";
				  }
				  else{
				    	if(file_exists($path .$file["name"])){
				    		$status['code'] = 0;
				    		$status['message'] = "File exists";
				    	}
				    	else{
				      		move_uploaded_file($file["tmp_name"], $path .strtolower($file["name"]));	
				      		$status['code'] = 1;			      		
				    	}
				  	}
		}
		else{

						for($i=0; $i< count($file['name']) ; $i++){

						$current_file['name'] = $file['name'][$i];
						$current_file['type'] = $file['type'][$i];
						$current_file['tmp_name'] = $file['tmp_name'][$i];
						$current_file['error'] = $file['error'][$i];

							   if($file["error"][$i] > 0) {
									    echo "Return Code: " . $file["error"][$i] . "<br>";
							  }
							  else{
							    	if(file_exists($path .$file["name"][$i])){
							    		$status['code'] = 0;
							    		$status['message'] = "File exists";
							    	}
							    	else{
							      		move_uploaded_file($file["tmp_name"][$i], $path .strtolower($file["name"][$i]));	
							      		$status['code'] = 1;			      		
							    	}
							  	}

						}
		}





		return $status;
	}


	public static function remove_recursively($path){


		$files = glob($path . '/*');
		
		foreach ($files as $file) {
			is_dir($file) ? self::remove_recursively($file) : unlink($file);
		}

			$status = rmdir($path);

		return $status;
	}






	public static function create_thumb($path,$imageName){

		@mkdir($path."thumbs");  

		$pathToImages = $path;
		$pathToThumbs = $path ."thumbs/";
		$thumbWidth = 300;

		 $dir = opendir( $pathToImages );

		  $fname = strtolower($imageName);

		    $info = pathinfo($pathToImages . $fname);
		    if ( strtolower($info['extension']) == 'jpg' ) 
		    {
		     // echo "Creating thumbnail for {$fname} <br />";

		      $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		      $width = imagesx( $img );
		      $height = imagesy( $img );

		      $new_width = $thumbWidth;
		      $new_height = floor( $height * ( $thumbWidth / $width ) );

		      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

		      @imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

		      @imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
		    }

		  closedir( $dir );


	}



	public static function get_dir_map($basedir=NULL){

			if(!$basedir){
				$basedir = getcwd();
			}


			$iter = new RecursiveIteratorIterator(
			    new RecursiveDirectoryIterator($basedir, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST,
			    RecursiveIteratorIterator::CATCH_GET_CHILD );

			$paths = array($basedir);
			foreach ($iter as $path => $dir) {
			    if ($dir->isDir()) {
			        $paths[] = $path;
			    }
			}

			return $paths;
	}



	public static function get_client_ip(){

	     if (isset($_SERVER['HTTP_CLIENT_IP'])){
	         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	     }
	     else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
	         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	     }
	     else if(isset($_SERVER['HTTP_X_FORWARDED'])){
	         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	     }
	     else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
	         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	     }
	     else if(isset($_SERVER['HTTP_FORWARDED'])){
	         $ipaddress = $_SERVER['HTTP_FORWARDED'];
	     }
	     else if(isset($_SERVER['REMOTE_ADDR'])){
	         $ipaddress = $_SERVER['REMOTE_ADDR'];
	     }
	     else
	         $ipaddress = 'UNKNOWN';

	     return $ipaddress; 
		
	}



}



?>