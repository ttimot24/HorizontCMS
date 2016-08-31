<?php 

class PluginController extends Controller{


	public function index(){

		if (!class_exists('ZipArchive')) {
			echo "<script>

				$('#upl').attr('disabled', true);

				</script>";

    	$this->view->message->setMessage('warning',"You have to enable php_zip.dll in your php configuration to be able to upload plugins.");
}

		$this->view->title = "Plugins";
		$this->view->render("plugins/index",[
												'all_plugin' => $this->model->get_plugins(),

												]);
	}



	public function __call($name, $args){

		if($app = $this->model->construct_instance($name)){

			if(!$app->check_dependencies()){
				throw new Error(6,"Missing dependencies for this plugin: <b>".$app->get_info('name')."</b>");
			}

			$this->view->title = $app->get_info('name');


			$this->view->render("../../plugins/".$name."/index");
		}
		else{
			throw new Error(7,"There's no plugin called: <b>".$name."</b>");
		}

	}



	public function install($args){


			$plugin = $this->model->construct_instance($args[0]);


			if($plugin->is_installable()){
				$install_queries = str_replace("@__",PREFIX,file_get_contents($plugin->path."/install.sql"));

				//$table_number = substr_count($install_queries,'CREATE TABLE');

				$table_names = array();

				$lines = explode(';',$install_queries);

				foreach($lines as $line){
					if(strpos($line, 'CREATE TABLE IF NOT EXISTS') !== false){
						$line_partial = explode('CREATE TABLE IF NOT EXISTS',$line);
						$words =  explode(" ", $line_partial[1]);
						$table_names[] = $words[1]; 
					}
					else if(strpos($line, 'CREATE TABLE') !== false){
						$line_partial = explode('CREATE TABLE',$line);
						$words =  explode(" ", $line_partial[1]);
						$table_names[] = $words[1]; 
					}
				}

				try{

					$stmt = $this->model->connection->prepare($install_queries);

					$stmt->execute();

					$stmt->closeCursor();

					$this->model->name = $plugin->get_info('name');
					$this->model->dir = $plugin->dir_name;
					$this->model->area = 0;
					$this->model->permission = 1;
					$this->model->table_name = json_encode($table_names);
					$this->model->active = 0;

					$query_status = $this->model->save();



				$query_status->code==00000?
					$this->view->message->setMessage('success','Successfully installed a new application!'):
					$this->view->message->setMessage('error','An error occured while installing the application!');

				}
				catch(PDOException $e){
					throw new Error(12,"Plugin installation error: ".$e->getMessage());
				}

			}

			$this->redirect('admin/plugin/');

	}

	public function uninstall(){
		var_dump(get_class_methods('Plugin'));
	}


/*	public function integrity($args){
		$plugin = $this->model->get_instance($args[0]);
		var_dump($plugin->check_dependencies());
	}*/


	public function upload(){

		$status = System::upload_file("plugins/",$_FILES['up_file']);

		$zip = new ZipArchive;
		$res = $zip->open('plugins/'.$_FILES['up_file']['name'][0]);
		if ($res === TRUE) {
		  $zip->extractTo('plugins/');
		  $zip->close();
		  unlink('plugins/'.$_FILES['up_file']['name'][0]);
		} 


		isset($status['code'])?
					$this->view->message->setMessage('success','Successfully upladed a new application'):
					$this->view->message->setMessage('error','An error occured while uploading the application!');


		$this->redirect_to_self();
	}



	public function delete($args){

		$status = System::remove_recursively("plugins/".$args[0]);
		


		$status?
				$this->view->message->setMessage('success',"Successfully removed the plugin"):
				$this->view->message->setMessage('error',"Something went wrong!");


		$this->redirect_to_self();
	}

}


?>