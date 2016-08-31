<?php 


/**
* This model is for the BlogpostsCategory. 
*
* @package horizontcms.model.blogpost
* @version 1.0
* @author Timot Tarjani
*
*/

class BlogpostCategory extends Model{ 

 

	public function count_posts(){
		$sth = $this->connection->prepare("SELECT count(*) as number FROM ".PREFIX."blogpost WHERE category= :id");
		$sth->execute([":id" => $this->id]);

		$number = $sth->fetchObject();

		$sth->closeCursor();

		return $number->number;
	}




	public function update($POST_ARRAY){

		$this->connection->query("UPDATE ".PREFIX."blogpost_category SET name='".$POST_ARRAY['category_name']."' WHERE id=".$POST_ARRAY['id']."");

		$this->error->addError($this->connection->errorInfo());

		return $this->error;
	}



	public function delete($id){

		$this->connection->prepare("DELETE FROM ".PREFIX."blogpost_category WHERE id= :id ")->execute([':id' => $id]);

		$this->error->addError($this->connection->errorInfo());

		return $this->error;
	}





} 


?>