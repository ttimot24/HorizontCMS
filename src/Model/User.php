<?php 


/**
* This model is for the Users. 
*
* @package horizontcms.model.users
* @version 1.3
* @author Timot Tarjani
*
*/

class User extends Model{ 


	public function authenticate($pass){

		//$pass = $this->connection->real_escape_string($pass);

		return (crypt($pass,$this->password)==$this->password);
	}


	public function increment_visits(){
		$this->connection->query("UPDATE ".PREFIX."user SET visits=visits+1 WHERE id=".$this->id."");
	}

	public function get_instance_by_username($username){

		$username = UrlManager::prepare_slug($username);

		$result = $this->connection->query("SELECT * FROM ".PREFIX."user WHERE username LIKE '".$username."'");

		$row = $result->fetchObject('User');

		$result->closeCursor();

		return $row;
	}

	public function get_active_users(){
		$result = $this->connection->query("SELECT * FROM ".PREFIX."user WHERE active=1 ");

		$active = array();

		while($user = $result->fetchObject('User')){
			array_push($active, $user);
		}

		$result->closeCursor();

		return $active;

	}
	

	public function get_user_blogposts(){

		$result = $this->connection->query("SELECT * FROM ".PREFIX."blogpost WHERE author='".$this->id."' ORDER BY id DESC");

		return $this->convert($result,'Blogpost');

	}

	public function get_comments(){

		$result = $this->connection->query("SELECT * FROM ".PREFIX."blogpost_comment WHERE user_id='".$this->id."' ");

		return $this->convert($result,'BlogpostComment');

	}


	public function get_rank(){
		$result = $this->connection->query("SELECT * FROM ".PREFIX."user_rank WHERE id=" .$this->rank);

		$error = $this->connection->errorInfo();

		echo $error[2];

		$rank = $result->fetchObject();

		$result->closeCursor();

		return $rank;
	}

	public function has_permission($permission){
		$user_group = $this->get_rank();

		foreach(json_decode($user_group->rights) as $key => $value){
			if($key==$permission && $value==1){
				//echo $key.": ".$value."<br>";
				return true;
			}
		}

		return false;
	}

	public function get_thumb(){

		/*if(file_exists("images/users/thumbs/" .$this->image) && $this->image!=""){
			return "images/users/thumbs/" .$this->image;
		}	
		else if(file_exists("images/users/" .$this->image) && $this->image!=""){
			return "images/users/".$this->image;
		}

		return "images/icons/profile.png";*/

		return Storage::get('images/users/thumb',$this->image,$this->get_image());
	}


	public function get_image(){

		/*if(file_exists("images/users/" .$this->image) && $this->image!=""){
			return "images/users/".$this->image;
		}

		return "images/icons/profile.png";*/

		return Storage::get('images/user',$this->image,"storage/images/icons/profile.png");
	}



	public function search($search){

		$search = str_replace(" -/*","%",$search);

		$stmt = $this->connection->prepare("SELECT * FROM ".PREFIX."user WHERE username LIKE :search OR name LIKE :search OR email LIKE :search ");

		$stmt->execute([':search' => strtolower("%".$search."%")]);

		return $this->convert($stmt);
	}





} 


?>