<?php 


/**
* This model is for the Page. 
*
* @package horizontcms.model.page
* @version 1.0
* @author Timot Tarjani
*
*/

class Page extends Model{


	public function new_instance_by_array($POST_ARRAY){

		$this->name = $this->connection->real_escape_string($POST_ARRAY['name']);
		$this->url = $this->connection->real_escape_string($POST_ARRAY['url']);
		$this->page = $this->connection->real_escape_string($POST_ARRAY['page']);

	}


	public function get_instance_by_name($title){

		$title = UrlManager::prepare_slug($title);

		$result = $this->connection->query("SELECT * FROM ".PREFIX."page WHERE name LIKE '".$title."'");

		$row = $result->fetchObject('Page');

		$result->closeCursor();

		return $row;


	}


	public function get_instance_by_function($title){

		$result = $this->connection->query("SELECT * FROM ".PREFIX."page WHERE url='".$title."' ");

		$row = $result->fetchObject('Page');

		$result->closeCursor();

		return $row;


	}


	public function get_parent_page(){
		$result = $this->connection->query("SELECT * FROM ".PREFIX."page WHERE id=".$this->parent." ");

		$row = $result->fetchObject('Page');

		$result->closeCursor();

		return $row;

	}

	public function get_welcome_page(){

		$settings = new Settings();

		return $this->get_instance($settings->get_setting('home_page'));
	}


	public function get_visible_pages(){

		$result = $this->connection->query("SELECT * FROM ".PREFIX."page WHERE visibility = 1 ");


		return $this->convert($result);
	}


	function get_child_pages(){

		$result = $this->connection->query("SELECT * FROM ".PREFIX."page WHERE parent=".$this->id."");

		return $this->convert($result);
	}


	public function get_thumb(){

	/*	if(file_exists("images/pages/thumbs/" .$this->image) && $this->image!=""){
			return "images/pages/thumbs/" .$this->image;
		}
		else{
			return $this->get_image();
		}*/


		return Storage::get('images/pages/thumb',$this->image,$this->get_image());
	}



	public function get_image(){

		/*if(file_exists("images/pages/" .$this->image) &&  $this->image!=""){
			return "images/pages/" .$this->image;
		}
		else{
			return "images/icons/page.png";
		}*/

		return Storage::get('images/page',$this->image,"storage/images/icons/page.png");
	}



	public function search($search){
		$stmt = $this->connection->prepare("SELECT * FROM ".PREFIX."page WHERE name LIKE :search OR page LIKE :search ");

		$stmt->execute([':search' => strtolower("%".$search."%")]);

		return $this->convert($stmt);
	}





}



?>