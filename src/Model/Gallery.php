<?php 



class Gallery extends Model{


	public function get_instance_by_directory($name){
		$stmt = $this->connection->prepare("SELECT * FROM ".$this->active_db_table." WHERE directory LIKE :name");
		$stmt->execute([':name' => $name]);


		$row = $stmt->fetchObject('Gallery');

		$stmt->closeCursor();

		return $row;
	}


	public function clean_dir_name($gallery_name){

		$dir_name = str_replace(' ', '_', $gallery_name);

        $dir_name = preg_replace('/[^A-Za-z0-9\-]/', '', $dir_name);

        $dir_name = strtolower($dir_name);

        return $dir_name;
	}





}