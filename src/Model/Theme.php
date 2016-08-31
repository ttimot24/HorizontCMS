<?php 


class Theme extends Model{

	/**************************************************/

	public function get_all(array $offset=NULL){

		$themes = array();

		foreach(array_slice(scandir("themes/"),2) as $each){
			$themes[] = $this->get_instance($each);
		} 

		return $themes;
	}


	public function get_active_theme(){
		$result = $this->connection->query("SELECT * FROM ".PREFIX."settings WHERE setting = 'Theme' ");

		$row = $result->fetchAll();

		$result->closeCursor();

		return $this->get_instance($row[0]['value']);
	}


	public function set($theme){

	 $sth = $this->connection->prepare("UPDATE ".PREFIX."settings SET value = :value WHERE setting = :setting ");
	 $sth->execute([':value' => $theme,':setting'=>"Theme"]);

	 return $query_status;
	}


	/**********************Instance object****************************/

	public function &get_instance($theme){

		if(!file_exists("themes/".$theme)){
			return NULL;
		}

		$obj = new self();
		$obj->dir_name = $theme;
		$obj->path = "themes/".$theme;
		$obj->image = "themes/".$theme."/preview.jpg";
		$obj->templates = !file_exists($obj->path.'/page_templates')? NULL : array_slice(scandir($obj->path.'/page_templates'),2);
		$obj->info = !file_exists($obj->path."/theme_info.xml")? FALSE : simplexml_load_file($obj->path."/theme_info.xml");

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
			//return "No information";
			return "None";
		}
	}



	public function get_page_templates(){

		if(file_exists($this->path."/page_templates/")){
			$templates = scandir($this->path."/page_templates/");
			return array_slice($templates, 2);
		}
		else{
			return NULL;
		}

	}




}





?>