<?php 

/**
* This model is for the Blogposts. 
*
* @package horizontcms.model.blogpost
* @version 1.4
* @author Timot Tarjani
*
*/

class Blogpost extends Model{



	public function get_all_blogpost(array $offset = NULL){

		$blogposts = $this->get_all($offset);

		return array_reverse($blogposts);
	}


	public function get_instance_by_name($title){

		$title = UrlManager::prepare_slug($title);

		$stmt = $this->connection->prepare("SELECT * FROM ".$this->active_db_table." WHERE title LIKE :title");
		$stmt->execute([':title' => $title]);


		$row = $stmt->fetchObject('Blogpost');

		$stmt->closeCursor();

		return $row;
	}


	public function get_thumb(){

		return Storage::get('images/blogpost','thumbs/'.$this->image,$this->get_image());

	}



	public function get_image(){

		return Storage::get('images/blogpost',$this->image,"storage/images/icons/newspaper.png");
	}



	public function get_author(){

		$stmt = $this->connection->prepare("SELECT * FROM ".PREFIX."user WHERE id= :id ");
		$stmt->execute([':id' => $this->author]);

		$user = $stmt->fetchObject('User');

		$stmt->closeCursor();

		return $user;
	}


	public function get_category(){


		$result = $this->connection->query("SELECT * FROM ".PREFIX."blogpost_category WHERE id='".$this->category."' ");

		$category = $result->fetchObject();

		$result->closeCursor();

		return $category;


	}


	public function get_comments(){


		$result = $this->connection->query("SELECT * FROM ".PREFIX."blogpost_comment WHERE blogpost_id=".$this->id."");


		return $this->convert($result,'BlogpostComment');
	}



	public function search($search){

		$stmt = $this->connection->prepare("SELECT * FROM ".$this->active_db_table." WHERE title LIKE :search OR summary LIKE :search OR text LIKE :search ORDER BY id DESC");

		$stmt->execute([':search' => strtolower("%".$search."%")]);

		return $this->convert($stmt);
	}


	public function search_in_titles($search){

		$stmt = $this->connection->prepare("SELECT * FROM ".$this->active_db_table." WHERE title LIKE :search ORDER BY id DESC");

		$stmt->execute([':search' => strtolower("%".$search."%")]);

		return $this->convert($stmt);

	}

	public function search_in_summary($search){

		$stmt = $this->connection->query("SELECT * FROM ".$this->active_db_table." WHERE summary LIKE :search ORDER BY id DESC");

		$stmt->execute([':search' => strtolower("%".$search."%")]);

		return $this->convert($stmt);
	}

	public function search_in_post_content($search){

		$stmt = $this->connection->query("SELECT * FROM ".$this->active_db_table." WHERE text LIKE :search ORDER BY id DESC");

		$stmt->execute([':search' => strtolower("%".$search."%")]);

		return $this->convert($stmt);
	}











}




?>