<?php 


class Settings extends Model{


	public function get_setting($key){
		$stmt = $this->connection->prepare("SELECT * FROM ".PREFIX."settings WHERE setting= :key");
		$stmt->execute([':key' => $key]);

		$row = $stmt->fetchObject();

		$stmt->closeCursor();

		return $row->value;
	}


	public function update($data){


		$keys = array_keys($data);

		$stmt = $this->connection->prepare("UPDATE ".PREFIX."settings SET value= :value WHERE setting= :setting ");
		
		foreach($keys as $key){
			
			$stmt->execute([':value' => $data[$key],':setting' => $key]);
			
			$this->error->addError($stmt->errorInfo());
		}

		$stmt->closeCursor();


		return $this->error;
	}
















}


?>