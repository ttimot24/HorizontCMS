<?php 


class SettingsController extends Controller{



	public function index(){

		$panels = [
					['name' => $this->view->language['website'] ,'link' => 'admin/settings/website','icon' => 'fa fa-globe'],
					['name' => $this->view->language['admin_area'] ,'link' => 'admin/settings/adminarea','icon' => 'fa fa-desktop'],
					['name' => $this->view->language['server'] ,'link' => 'admin/settings/server','icon' => 'fa fa-server'],
					['name' => $this->view->language['email'] ,'link' => 'admin/settings/email','icon' => 'fa fa-envelope'],
					['name' => $this->view->language['social_media'] ,'link' => 'admin/settings/socialmedia','icon' => 'fa fa-thumbs-o-up'],
					['name' => $this->view->language['backup_database'] ,'link' => 'admin/settings/backupdatabase','icon' => 'fa fa-database'],
					['name' => $this->view->language['spread'] ,'link' => 'admin/settings/spread','icon' => 'fa fa-paper-plane'],
					['name' => $this->view->language['uninstall'] ,'link' => 'admin/settings/uninstall','icon' => 'fa fa-exclamation-triangle'],

					];



		$this->view->title = $this->view->language['settings'];
		$this->view->render("settings/panels",['panels' => $panels]);
	}


	protected function update(){

		if($this->request->getPost('website_down') == ""){
			$this->request->setPost('website_down',0);
		}


		if($this->request->typeEquals('POST')){
			$query_status = $this->model->update($this->request->getArray('POST'));

			$query_status->code==00000? 
						$this->view->message->setMessage('success','Settings saved.') : 
						$this->view->message->setMessage('error',$query_status->message);
		}


	}



	public function website(){

		if($this->request->typeEquals('POST')){
			$this->update();
			$this->redirect_to_self();
		}
		else{
			$this->view->css('resources/assets/checkboxmaster/build.css');
			$this->view->title = "Website settings";
			$this->view->render("settings/website",[
													'title' => $this->model->get_setting('title'),
													'site_name' => $this->model->get_setting('site_name'),
													'slogan' => $this->model->get_setting('slogan'),
													'scroll_text' => $this->model->get_setting('scroll_text'),
													'contact' => $this->model->get_setting('contact'),
													'debug_mode' => $this->model->get_setting('website_debug'),
													'logo' => $this->model->get_Setting('logo'),
													'website_down' => $this->model->get_Setting('website_down'),
													]);
		}
	}


	public function adminarea(){

		if($this->request->typeEquals('POST')){
			$this->update();
			$this->redirect_to_self();
		}
		else{

			$languages = array_slice(scandir('resources/languages'),2);

			$this->view->title = "Admin settings";
			$this->view->render("settings/adminarea",[
														'languages' => $languages,
														'current_language' => $this->model->get_setting('language'),
														'admin_logo' =>$this->model->get_setting('admin_logo'),
													 ]);
		}
	}


	public function server(){

		$this->update();


		$this->view->title = "Server settings";
		$this->view->render("settings/server");
	}

	public function email(){

		$this->update();


		$this->view->title = "Email settings";
		$this->view->render("settings/email");
	}


	public function updatecenter(){
		$this->view->title = "Update Center";
		$this->view->render("settings/update_center",[
			'latest_version' => SystemUpdate::get_upgrade_info('latest_version'),
			'current_version' => SystemUpdate::get_upgrade_info('current_version'),
			'installed_version' => SystemUpdate::get_upgrade_info('installed_version'),
			'upgrade_list' => SystemUpdate::get_upgrade_info('upgrade_list'),
			'available_list' => SystemUpdate::get_upgrade_info('available_list'),
			]);
	}


	public function socialmedia(){

		$stmt = System::$connection->prepare("UPDATE ".PREFIX."socialmedia SET link= :link WHERE social_media= :soc_me ");

		if($this->request->typeEquals('POST')){

			foreach($_POST as $s_media => $link){
				$stmt->execute([':link' => $link,':soc_me' => $s_media]);
			}


			if($stmt->errorCode()==00000){
				$this->view->message->setMessage('success','All links saved successfully');
			}
			else{
				$this->view->message->setMessage('error','There was an error!');
			}

		
			$stmt->closeCursor();	
		}
		

		$social = new Socialmedia();

		$this->view->title = "Social Media settings";
		$this->view->render("settings/socialmedia",["socialmedia" => $social,"all" => $social->get_all()]);
	}


	public function spread(){

			if(!function_exists('fsockopen')) {
				$this->view->message->setMessage('error',"FTP is disabled on this server! Sorry we can't use the <i><b>Spread</b></i> function");
			}


		$this->view->title = "Spread";
		$this->view->render("settings/spread");
	}




	public function uninstall(){


		$this->view->title = "Uninstall";
		$this->view->render("settings/uninstall");
	}


	public function uploadlogo(){

			$status = System::upload_file(Storage::$path.'/images/logos/',$_FILES['up_file']);

				if($status['code']){
					$this->view->message->setMessage('success','Successfully uploaded an image!');
				}
				else{
					$this->view->message->setMessage('error','Image upload failed!');
				}


		$this->redirect_to_self();
	}

	public function setlogo($args){

		if($args[0] == "website"){
			//$_POST['logo'] = $args[1];
			$this->request->setPost('logo',$args[1]);
		}
		else{
			//$_POST['admin_logo'] = $args[1];
			$this->request->setPost('admin_logo',$args[1]);
		}
		

		//$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->request->changeType('POST');

		$this->update();

		$this->redirect_to_self();
	}


	public function backupdatabase($redirection = TRUE){
		
		$tables = array();
		$create_table = "";
		$insert_statements = "";
		$statement = "";

		Storage::create('dir','backup');

		$result = System::$connection->query("SHOW TABLES");



		while($row = $result->fetch()){
			array_push($tables,$row[0]);
		}

		foreach($tables as $table){
			$result = System::$connection->query('SHOW CREATE TABLE '.$table);

			$row = $result->fetch();

			$create_table .= $row[1].";"; 

		}


		foreach($tables as $table){
			$result = System::$connection->query('SELECT * FROM '.$table);
			
			while($row = $result->fetch()){

				for($i=0;$i<count($row)/2;$i++){
				
					if(is_numeric($row[$i])){
						$statement .= $row[$i] .",";
					}
					else{
						$statement .= "'".$row[$i]."',";
					}

				}

				$statement = rtrim($statement,",");


				$insert_statements .= "INSERT INTO " .$table." VALUES (".$statement.");";

				$statement = "";
			}
		}


		//var_dump($insert_statements);
	    $file = fopen("backup/prefix.txt", "w+") or die("Unable to open file!");
	    $status = fwrite($file,PREFIX);
	    fclose($file);
	    

	    $file = fopen("backup/backup.txt", "w+") or die("Unable to open file!");

	    $txt = $create_table."\n\n".$insert_statements;


	    $status = fwrite($file,$txt);

	    fclose($file);


			if($status){
				$this->view->message->setMessage('success','Backup created successfully!');
			}
			else{
				$this->view->message->setMessage('error','Something went wrong');
			}

			if($redirection==TRUE){
				$this->redirect_to_self();
			}
	}


	public function spreadaction(){

			if(isset($_POST['datab']) && $_POST['datab']==1){
				$this->backupdatabase(FALSE);
			}



			if(!function_exists('fsockopen')) {
				die("FTP is not enabled");
			}

			$this->view->message->setMessage('success',"FTP is enabled on this server!");


					$ftp_conn = ftp_connect($_POST['server']);
					$ftp_login = ftp_login($ftp_conn, $_POST['ftp_user'], $_POST['ftp_pass']);
									ftp_pasv($ftp_conn, true);
					

					if($ftp_conn && $ftp_login){
						$this->view->message->setMessage('success',"Connection established with the FTP server!");

						if(isset($_POST['ftp_basedir'])){
							$status = @ftp_mkdir($ftp_conn, $_POST['ftp_basedir']);


							$status? 	$this->view->message->setMessage('success',"Base directory created"): 	
										$this->view->message->setMessage('error',"Could not create the base directory");
							}
						

						$paths = System::get_dir_map();

						
							foreach($paths as $each){

//								if($each==""){ continue; }

								$each = explode(BASE_DIR,$each);
								$each = $each[1];

//								if($each==""){ continue; }

								$server_folder = $_POST['ftp_basedir'] ."".$each;		


							//	echo "FOLDER: ".$each ." SERVER FOLDER: ".$server_folder;


								if (@ftp_mkdir($ftp_conn, $server_folder)) {
										$statuses[$server_folder] = 'success'; 									
									} 
									else{
										$statuses[$server_folder] = 'danger';  	
									}



									$files = scandir(ltrim($each,"/"));	
									array_push($files, "index.php");
									array_push($files, ".htaccess");		

										foreach(array_slice($files,2) as $each_file){
												

													$local_file = ltrim($each,"/")."/".$each_file;
													
													$server_file = $server_folder."/".$each_file;

											//	echo "LOCAL FILE: " .$local_file." SERVER FILE: ".$server_file ."<br><br>";


												if(is_file($local_file) && !strpos($local_file,"config.php")){
													

													$upload = ftp_nb_put($ftp_conn, $server_file, $local_file, FTP_BINARY);


														while ($upload == FTP_MOREDATA){
															  $upload = ftp_nb_continue($ftp_conn);
															  }


														if ($upload == FTP_FINISHED){
														  	$statuses[$local_file] = 'success'; 	
														  }
														else{
															$statuses[$local_file] = 'danger'; 	
															}

										
											
												}

												unset($local_file);										
												unset($server_file);
													

										}

									
							} 

							
						  ftp_close($ftp_conn);

						}
						else{
							$this->view->message->setMessage('error',"Communication failed with the FTP server!");
						}







		$this->view->title = "Spread";
		$this->view->render("settings/spreadend",[ 'statuses' => $statuses ] );

	}




}



?>