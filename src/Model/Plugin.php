<?php 


class Plugin extends Model{

	public $none = NULL;


	public static function is_installed($plugin_name=NULL){

		$obj = new self();

		isset($plugin_name)? : $plugin_name = static::class;


		foreach($obj->get_all() as $plugin){
			if(strtolower($plugin->dir) == strtolower($plugin_name)){
				return TRUE;
			}
		}
		
		return FALSE;
	}





	public static function area($area){

		if(!is_int($area)){
			return;
		}



		$obj = new self();

		$plugins = $obj->get_all();

		foreach ($plugins as $plugin) {
			if($plugin->area == $area && $plugin->active==1){

					require_once("plugins/".$plugin->dir."/model/".ucfirst(strtolower($plugin->name)).".php");

				
					$module = new $plugin->name();

					if(method_exists($module,'show')){
						$module->show();
					}
					else{
						echo "<b>FatalError:</b> ".$plugin->name."'s show() method doesn't exists!";
						//exit;
					}



			}
		}

	}


/***************************************************************************************************************/

	public function get_plugins(){

		$all_plugin = array();

		foreach(array_slice(scandir("plugins"),2) as $each){
			$all_plugin[] = $this->construct_instance($each);
		}

		return $all_plugin;
	}


	public function &construct_instance($plugin){

		if(!file_exists("plugins/".$plugin)){
			return $this->none;
		}

		$obj = new self();
		$obj->dir_name = $plugin;
		$obj->path = "plugins/".$plugin;
		$obj->icon = "plugins/".$plugin."/icon.jpg";
		//$obj->templates = !file_exists($obj->path.'/page_templates')? NULL : array_slice(scandir($obj->path.'/page_templates'),2);
		$obj->info = !file_exists($obj->path."/plugin_info.xml")? FALSE : simplexml_load_file($obj->path."/plugin_info.xml");

		return $obj;
	}


	public function get_info($info){
		
		if(isset($this->info->{$info})){
			return $this->info->{$info};
		}
		else if($info=='name'){
			return $this->dir_name;
		}
		else{
			return "No information";
		}
	}


	public function is_installable(){
		if(file_exists($this->path."/install.sql")){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}



	public function check_dependencies(){

		$plugin_row = $this->connection->query("SELECT * FROM ".PREFIX."plugin WHERE dir='".$this->dir_name."' OR name='".$this->get_info('name')."'");

		$plugin = $this->convert($plugin_row);

		if(isset($plugin[0]->table_name)){
			foreach(json_decode($plugin[0]->table_name) as $each){
				$result = $this->connection->query("SHOW TABLES LIKE '".$each."'");

				if(!$result->fetchObject()){
					return FALSE;
				}
			}
		}

		return TRUE;
	}





}







?>