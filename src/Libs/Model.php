<?php

/**
* This is the model core. All model's parent class. 
*
* @package horizontcms.model
* @version 1.3
* @author Timot Tarjani
*
*/

//namespace Horizontcms\Lib;

abstract class Model{

	protected $childClass;
	protected $active_db_table;


	/**
	* This is the Model constructor. 
	* It establish the databse connection.
	*
	*/


	public function __construct(){

		$this->childClass = get_called_class();

		$this->connection = isset(System::$connection)? System::$connection : System::establish_connection();

		$this->active_db_table = PREFIX.$this->class_to_table();

		$this->error = new ErrorReport();

	}

	/**
	*
	* Creates and sets a class variable by params.
	* @param $variable The name of the variable
	* @param $value The value of the variable
	*
	*/


	public function setValue($variable,$value){
		if(is_string($variable)){
			$this->{$variable} = $value;
		}
	}


	/**
	*	Creates an object for the called object from an array.
	*	@param $POST_ARRAY An array with the datas.
	*
	*/


	public function construct_by_array($POST_ARRAY){

		foreach ($POST_ARRAY as $key => $value) {
			$this->setValue($key,$value);
		}
	}



	/**
	* This method is shorten of the get_instance_by('id',$value);
	* @param int $id. An integer which is the id one of the instance. 
	* 
	* @return $instance The requested instance from the database.
	*/
	public function get_instance($id){

		$sth = $this->connection->prepare("SELECT * FROM ".$this->active_db_table." WHERE id= :id");
		$sth->execute([':id' => $id]);

		$instance = $sth->fetchObject($this->childClass);

		$sth->closeCursor();

		return $instance;
	}


	/**
	* @param string $by The attribute which we want to select by. 
	* @param mixed $value Value of the attribute.
	* @return $instance The requested instance from the database.
	*/
	public function get_instance_by($by,$value){

		$sth = $this->connection->prepare("SELECT * FROM ".$this->active_db_table." WHERE :by= :value");
		$sth->execute([
						':by' => $by,
					    ':value' => $value
					  ]);

		$instance = $sth->fetchObject($this->childClass);

		$sth->closeCursor();

		return $this->convert($sth);
	}

	/**
	* Select all data from database.
	* @param $offset. Optional. You can add a Limit and Offset to the SQL query.
	*
	* @return Returns an array with the object instances.
	*/
	public function get_all(array $offset=NULL){

		$sql = "SELECT * FROM ".$this->active_db_table;

		!isset($offset[1])?  : $sql.=" LIMIT " .$offset[1]; !isset($offset[0])?  : $sql.= " OFFSET " .$offset[0];


		$sth = $this->connection->prepare($sql);
		$sth->execute();

		return $this->convert($sth);

	}


	/**
	* Select last N row from the entity table.
	* @param $num - N number
	*
	* @return Returns an array with the object instances.
	*/

	public function get_last($num){

		$sql = "SELECT * FROM (SELECT * FROM ".$this->active_db_table." ORDER BY id DESC LIMIT ".$num.") sub ORDER BY id ASC";

		$sth = $this->connection->prepare($sql);
		$sth->execute();

		return $this->convert($sth);
	}


	/**
	* 
	*
	* @return int $number The number of rows in the database.
	*/


	public function countAll(){

		$sql = "SELECT count(*) as number FROM ".$this->active_db_table;

		$result = $this->connection->query($sql);

		$row = $result->fetchObject();

		$result->closeCursor();

		return $row->number;
	}

	/**
	* Saves the object into the database
	* 
	*
	* @return $error Returns the query status.
	*/


	public function save(){

		$columns_array = array_slice($this->get_column_names(),1); //skip id

		$sql = "INSERT INTO ".$this->active_db_table." VALUES(default,";

		foreach($columns_array as $column){
					if(isset($this->{$column->Field})){
							$sql .=  ":".$column->Field.",";
					}
		}

		$sql = rtrim($sql,",");
		$sql .= ")";

	
		$sth = $this->connection->prepare($sql);


		$sth->execute($this->create_db_array($columns_array));

		$this->error->addError($sth->errorInfo());

		return $this->error;
	}


	/**
	* Updates the object in the database
	* 
	*
	* @return $error Returns the query status.
	*/


	public function updatex(){

		$columns_array = array_slice($this->get_column_names(),1); //skip the id column


		$sql = "UPDATE ".$this->active_db_table." SET ";

		foreach($columns_array as $column){

			if(isset($this->{$column->Field})){
				$sql .= $column->Field ." = :".$column->Field.",";
		    }

		}


		$sql = rtrim($sql,",");

		$sql .= " WHERE id= :id" ;


		$sth = $this->connection->prepare($sql);

		$db_array = $this->create_db_array($columns_array);
		$db_array[':id'] = $this->id;

		$sth->execute($db_array);


		$this->error->addError($sth->errorInfo());

		$sth->closeCursor();

		return $this->error;
	}

	/**
	* Delete the object from the database.
	* 
	*
	* @return $error Returns the query status.
	*/


	public function delete($id){

		$sth = $this->connection->prepare("DELETE FROM ".$this->active_db_table." WHERE id= :id");
		$sth->execute([':id' => $id ]);
		
		$this->error->addError($sth->errorInfo());

		return $this->error;
	}


	/**
	* It convert the ResultSet into object array.
	* 
	*
	* @return $instances The array of objects.
	*/

	protected function convert($result,$object=NULL){

		if(!isset($object) || $object==''){
		
			$object = $this->childClass;
		
		}

		$instances = array();

		while($row = $result->fetchObject($object)){
			array_push($instances,$row);
		}

		$result->closeCursor();

		return  $instances;


	}



	private function class_to_table(){
		$called_class = lcfirst($this->childClass);

		$capital_char = strcspn($called_class, 'ABCDEFGHJIJKLMNOPQRSTUVWXYZ');

		$db_table_name = rtrim(substr_replace($this->childClass, "_", $capital_char, 0),"_");

		return strtolower($db_table_name);
	}



	private function get_column_names(){


		$result = $this->connection->query("SHOW columns FROM ".$this->active_db_table."");

		$column_names = array();

		while($row = $result->fetchObject()){
			array_push($column_names, $row);
		}

		$result->closeCursor();

		return $column_names;
	}


	protected function create_db_array($columns_array){

		foreach($columns_array as $column){
			if(isset($this->{$column->Field})){
				$columns[":".$column->Field] = $this->{$column->Field};
			}
		}

		return $columns;
	}



	public function getClass(){
		return $this->childClass;
	}


}



?>