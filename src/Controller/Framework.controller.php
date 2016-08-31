<?php 

class FrameworkController extends Controller{


	function index(){
		$this->view->render("framework/index");
	}


	function model(){

		//$this->model = new Model();
		$this->load_model('Model');

		$result = $this->model->connection->query("SELECT table_name FROM INFORMATION_SCHEMA.TABLES  WHERE table_schema = '" .DATABASE ."'");

		$tables = array();

		while($row = $result->fetchObject()){

			$row->table = $row->table_name;
			array_push($tables,$row->table);
		}

		$this->view->render("framework/model",$tables);
	}

	function controller(){

		$this->view->render("framework/controller");
	}


	function generate($type){


		if($type[0]=='model'){


			$model_name = str_replace("_"," ",$this->request->getPost('model_table'));

			$model_name = ucwords($model_name);

			$model_name = str_replace(" ","",$model_name);

			$fp = fopen($this->request->getPost('model_path').$model_name.'.php','w');

			$file_content = "<?php ";
			$file_content .= "\n\nclass ".$model_name." extends Model{ \n\n \n\n} \n\n";
			$file_content .= "\n?>";

			$status = fwrite($fp, $file_content);
			fclose($fp);

			if($status === FALSE){

			}
			else{
				$this->view->render("framework/index");
			}

		}

	}




}


?>