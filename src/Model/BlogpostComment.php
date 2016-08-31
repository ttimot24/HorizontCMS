<?php 

/**
* This model is for the BlogpostsComment. 
*
* @package horizontcms.model.blogpost
* @version 1.0
* @author Timot Tarjani
*
*/

class BlogpostComment extends Model{


	public function get_author(){

		$user = new User();

		return $user->get_instance($this->user_id);
	}

	public function getBlogpost(){
		return (new Blogpost())->get_instance($this->blogpost_id);
	}


}




?>