<?php 


class Security extends Model{

/*	public static function secure_session_start(){

		require_once("libs/handlers/SafeSessionHandler.php");

		$handler = new SafeSessionHandler();
		session_set_save_handler($handler, true);
		session_start();
	}
*/

	public static function secure_session_start(){
		
		$session_name = 'sec_session_id';   // Set a custom session name
	    $secure = FALSE;
	    // This stops JavaScript being able to access the session id.
	    $httponly = true;
	    // Forces sessions to only use cookies.
	    if (ini_set('session.use_only_cookies', 1) === FALSE) {
	        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
	        exit();
	    }
	    // Gets current cookies params.
	    $cookieParams = session_get_cookie_params();
	    session_set_cookie_params($cookieParams["lifetime"],
	        $cookieParams["path"], 
	        $cookieParams["domain"], 
	        $secure,
	        $httponly);
	    // Sets the session name to the one set above.
	    session_name($session_name);
	    session_start();            // Start the PHP session 
	    session_regenerate_id(true);    // regenerated the session, delete the old one. 

	}


	public static function secure_session_destroy(){

			$_SESSION = array();
			 
			// get session parameters 
			$params = session_get_cookie_params();
			 
			// Delete the actual cookie. 
			setcookie(session_name(),
			        '', time() - 72000, 
			        $params["path"], 
			        $params["domain"], 
			        $params["secure"], 
			        $params["httponly"]);
			 
			// Destroy session 
			session_destroy();

	}


	/*public function avoid_sql_injection($text){

		return $this->$connection->real_escape_string($text);
	}*/



	public static function password_encrypt($password){

		$hash_format = "$2y$10$";
		$salt = self::generate_salt();

		//"prwsquvb11yioa78fhj3mn"; //

		$hash = crypt($password,$hash_format.$salt);
		return $hash;

	}

	public static function generate_salt(){
		$default_salt_length = 22;

		$salt = md5(uniqid(mt_rand(),true));
		$salt = base64_encode($salt);
		$salt = str_replace('+','.',$salt);
		$salt = substr($salt,0,$default_salt_length);

		return $salt;
	}



	public static function checkAuth(){

		if(Session::get('username')==NULL){

			$link = str_repeat("../", count(UrlManager::get_slugs())) ."admin/login";

			header('Location: ' .$link);
			exit;
		
		}else if(Session::get('permission')<4){
			header('Location: ' .str_repeat("../", count(UrlManager::get_slugs())));
			exit;
		}


	}










}



?>