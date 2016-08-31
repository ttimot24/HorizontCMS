<?php 

class AjaxController extends Controller{

	public $intervall = 7;
	public $user;

	public function before(){

		$this->load_model('User');
		$this->load_model('Blogpost');

	}


	function sayhello(){
		echo "Hello World! The Ajax Call is up to work!";
	}


	public function ajaxGetNotices(){

		$time = time();

		$all_user = $this->user->get_all();
		$user = end($all_user);

		if(($time - $user->reg_date <= $this->intervall)){
			echo "<b>New user: </b></br> <a href='admin/user/view/".$user->id."'>" .$user->username ."</a></br>";
		}


		$all_blogpost = $this->blogpost->get_all();
		$blogpost = end($all_blogpost);

		if(($time - $blogpost->date <= $this->intervall)){
			echo "<b>New post: </b></br><a href='admin/blogpost/view/".$blogpost->id."'> " .$blogpost->title ."</a>";
		}



	}


	public function ajaxConvertSlug($text){
		echo UrlManager::seo_url($text[0]);
	}



	function checkUsername($username=NULL){


		if($username!=NULL){
			$user = $this->user->get_instance_by_username($username[0]);

			if($user!=NULL){	
				echo "Ez a felhasználó név már foglalt!";
			}
			else{
				echo 0;
			}
		}



	}



}



?>