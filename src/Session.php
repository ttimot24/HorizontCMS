<?php 

	
class Session{


		public static function start(){
			if (session_status() == PHP_SESSION_NONE) {
			    session_start();
			}
		}

		public static function secure_start(){	
			Security::secure_session_start();
		}



		public static function set($key,$value){
			$_SESSION[$key] = $value;
		}


		public static function get($key){

			if(isset($_SESSION[$key])){
				return $_SESSION[$key];
			}else{
				return NULL;
			}

		}


		public static function unset_key($key){
			if(isset($_SESSION[$key])){
				unset($_SESSION[$key]);
			}
		}


		public static function destroy(){
			session_destroy();
		}


		public static function secure_destroy(){

			Security::secure_session_destroy();

		}



	}



?>