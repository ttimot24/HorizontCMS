<?php 



class Post{


		public static function set($key,$value){
			$_POST[$key] = $value;
		}





		public static function get($key){

			if(isset($_POST[$key])){
				return $_POST[$key];
			}else{
				return NULL;
			}

		}



	/*	public static function unset($key){

			unset($_POST[$key]);

		}
*/

















}