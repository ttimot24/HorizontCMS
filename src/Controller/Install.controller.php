<?php 


class InstallController extends Controller{

	public function __construct(Request $request){
		$this->request = $request;

		$this->view = new View(new Navigation([],'english'),'english');

		Session::start();

	}



	public function index(){

		$htaccess_file = ".htaccess";

		if(!is_writable(getcwd())){
			$this->view->message->setMessage('warning','Change the root directory permissons before continuing!');
			$enable_continue = FALSE;
		}
		else{
			$enable_continue = TRUE;


				$htaccess = fopen($htaccess_file, "w");

				if(!$htaccess){
					$this->view->message->setMessage('error','Permission denied for create .htaccess file!');
				}
				else{
				$txt = "RewriteEngine On\r\n
					\r\nRewriteCond %{REQUEST_FILENAME} !-f\r\nRewriteCond %{REQUEST_FILENAME} !-d\r\nRewriteCond %{REQUEST_FILENAME} !-l\r\n\r\n\r\nRewriteRule ^(.+)$ index.php?url=$1 [QSA,L]\r\n";

				fwrite($htaccess, $txt);

				fclose($htaccess);
				}
		}

		if(file_exists("core/config.php")){
			$this->view->title ='Installing';

			$this->view->render("install/error",NULL,TRUE);
		}
		else if(file_exists("backup/backup.txt")){

			$this->view->title ='Through install';
			$this->view->renderPartial("install/trough");
		}
		else{

			$this->view->title ='Installing';
			$this->view->renderPartial("install/index",['enable_continue' => $enable_continue]);
		}
	}


	public function step1(){

		$this->view->title = "Intsall Step 1";
		$this->view->renderPartial("install/step1");
	}


	public function step2(){

		if(isset($_POST['lang']) && $_POST['lang']!=""){
			Session::set('language',$_POST['lang']);
		}


		$this->view->title = "Intsall Step 2";
		$this->view->renderPartial("install/step2",['session' => $_SESSION,'db_drivers' => PDO::getAvailableDrivers()]);
	}

	public function checkconnection(){


		try{
		    
		    $con = new PDO($_POST['db_driver'].':host=localhost;', $_POST['username'], $_POST['password']);
		    
		    $con = NULL;

		    $this->view->message->setMessage('success',"Database server connection is OK!");


					if(isset($_POST['username']) && $_POST['username']!="" && isset($_POST['password']) && $_POST['password']!=""){
						Session::set('db_driver',$_POST['db_driver']);
						Session::set('server',$_POST['server']);
						Session::set('install_username',$_POST['username']);
						Session::set('install_password',$_POST['password']);
						Session::set('database',$_POST['database']);
						Session::set('prefix',$_POST['prefix']);
					}


			$this->redirect('admin/install/step3');
		}catch (PDOException $e) {
			   $this->view->message->setMessage('error','Could not connect to database server! ' .$e->getMessage());
			   $this->redirect('admin/install/step2');
		}

	}

	
	public function step3(){

					$this->view->title = "Intsall Step 3";
					$this->view->renderPartial("install/step3",['session' => $_SESSION]);


	}




	public function step4(){

		$this->view->title = "Intsall Step 4";
		$this->view->renderPartial("install/step4",['session' => $_SESSION]);
	}




	public function chmod_r($path = "/"){
	    $dir = new DirectoryIterator($path);
	    foreach ($dir as $item) {
	        chmod($item->getPathname(), 0777);
	        if ($item->isDir() && !$item->isDot()) {
	            $this->chmod_r($item->getPathname());
	        }
	    }
	}



	public function create_config_file($db_driver,$server,$username,$password,$database,$prefix=NULL){

		//$this->chmod_r();

		if(!file_exists("core/config.php")){
		$myfile = fopen("core/config.php", "w") or die("Unable to open file!");

		$txt = 
		"<?php\n
		  DEFINE ('DB_DRIVER','".$db_driver."');
		  DEFINE ('DB_CHARSET','utf8');
		  DEFINE ('SERVER','" .$server ."');
		  DEFINE ('USERNAME','" .$username ."');
		  DEFINE ('PASSWORD','" .$password."');
		  DEFINE ('DATABASE','" .$database ."');\n
		  DEFINE ('PREFIX','" .$prefix ."');\n
		  \n\n
		?>";

		fwrite($myfile, $txt);
		fclose($myfile);
		  return TRUE;
		}
		else{
		  return FALSE;
		}


	}




public function migrate(){

	//var_dump($_SESSION);

		if(isset($_POST['ad_username']) && $_POST['ad_username']!="" && isset($_POST['ad_password']) && $_POST['ad_password']!=""){
			Session::set('ad_username',$_POST['ad_username']);
			Session::set('ad_password',$_POST['ad_password']);
			Session::set('ad_email',$_POST['ad_email']);
		}



		if(file_exists("core/horizontcms.sql")){
			$create_tables = str_replace("@__",Session::get('prefix'),file_get_contents("core/horizontcms.sql"));
		}
		else{
			echo "Missing component of HorizontCMS: <b>core/horizontcms.sql</b>";
			exit;
		}


		try{
			$PDO_connection = new PDO(Session::get('db_driver').":host=".Session::get('server').";charset=utf8", Session::get('install_username'), Session::get('install_password'));
	

			if (!$PDO_connection->query("CREATE DATABASE IF NOT EXISTS " .Session::get('database')) === TRUE) {
			    throw new PDOException ("Error creating database: " . $PDO_connection->error);
			}
				


			$PDO_connection->query("use ".Session::get('database'));


			$stmt = $PDO_connection->prepare($create_tables);

			$stmt->execute();



		}
		catch(PDOException $e){
			$e->getMessage();
		}





		$all_insert_sql_query = array(
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'title','Title',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'site_name','HorizontCMS Site',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'slogan','Some slogan',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'theme','twentyt',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'scroll_text','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'contact','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'language','".strtolower($_SESSION['language'])."',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'website_type','website',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'logo','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'admin_logo','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'admin_theme','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'admin_background','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'home_page','1',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'website_debug','1',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'admin_debug','1',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'website_down','0',1)"),

				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia VALUES(default,'facebook','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia VALUES(default,'youtube','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia VALUES(default,'instagram','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia VALUES(default,'twitter','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia VALUES(default,'soundcloud','',1)"),

				array("query" => "INSERT INTO {$_SESSION['prefix']}blogpost VALUES(default,'Welcome you','This is a sample news for HorizontCMS.','If you see this post than the installation was successfull. Go to the admin area to edit or delete this post.',".time().",1,1,'none')"),

				array("query" => "INSERT INTO {$_SESSION['prefix']}user VALUES(default,'Administrator','" .$_SESSION['ad_username'] ."','".Security::password_encrypt($_SESSION['ad_password'])."',6,'".$_SESSION['ad_email']."',1,".time().",0,1,'')"),

				array("query" => "INSERT INTO {$_SESSION['prefix']}page VALUES(default,'First page','news.php',1,0,0,'','')"),



	);





		foreach ($all_insert_sql_query as $insert_sql) {
			$stmt = $PDO_connection->prepare($insert_sql['query']);
			$error = $stmt->execute();

			if( $stmt->errorCode() != 00000 ){
				echo "<b>Light weight error: </b>" .$error['message'] ."<br>";
			}
		}




		$PDO_connection = null;

		$this->create_config_file(Session::get('db_driver'),$_SESSION['server'],$_SESSION['install_username'],$_SESSION['install_password'],$_SESSION['database'],$_SESSION['prefix']);

		//Security::secure_session_destroy();
		session_destroy();

		$this->view->message->setMessage('success',"Installation was succesfull!");

		$this->redirect("admin/install/step4");
		
	}


	public function through1(){

		$this->view->title = "Databse details";
		$this->view->renderPartial("install/through1");
	}


	public function spread(){

		session_start();

		try{
			$PDO_connection = new PDO($_POST['db_driver'].":host=".$_POST['server'].";dbname=".$_POST['database'], $_POST['install_username'], $_POST['install_password']);
		}
		catch(PDOException $e){
			$e->getMessage();
		}
	

		$sql = "CREATE DATABASE IF NOT EXISTS " .$_POST['database'] ."";
		if (!$PDO_connection->query($sql) === TRUE) {
		    throw new Exception ("Error creating database: " . $PDO_connection->error);
		}
		


		$PDO_connection->query("use ".$_POST['database']);




		$file = fopen("backup/backup.txt", "r+") or die("Unable to open file!");
		$backup_content = fread($file,filesize("backup/backup.txt"));
		fclose($file);

		$backup_content = explode(";",$backup_content);

		foreach ($backup_content as $line) {
			//echo $line ."<br><br>";
			$status = @$PDO_connection->query($line);

		}

		$PDO_connection =null;


		$file = fopen("backup/prefix.txt", "r+") or die("Unable to open file!");
		$prefix = fread($file,filesize("backup/prefix.txt"));
		fclose($file);


		$status = $this->create_config_file($_POST['server'],$_POST['username'],$_POST['password'],$_POST['database'],$prefix);

		/*if($status){
			$this->view->message->setMessage('success',"Succesfully created the config file!");
		}
		else{
			$this->view->message->setMessage('error',"FATAL ERROR: Couldn't create config file!");
		}*/

		session_destroy();
		$this->view->title = "Spread";
		$this->view->renderPartial('install/step4');
	}






}





















































	/*	$all_create_sql_query = array(
				array("name" => $_SESSION['prefix'] ."settings" , "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}settings (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,setting VARCHAR(255),value TEXT,more INT(8),UNIQUE(setting))"),
				array("name" => $_SESSION['prefix'] ."socialmedia_settings", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}socialmedia (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,social_media VARCHAR(255),link VARCHAR(255),more INT(8))"),
				array("name" => $_SESSION['prefix'] ."blogpost", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}blogpost (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,title VARCHAR(255) NOT NULL,summary VARCHAR(700),text TEXT,date int(11),author int(8),category int(8),image VARCHAR(255))"),
				array("name" => $_SESSION['prefix'] ."blogpost_category", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}blogpost_category (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255))"),
				array("name" => $_SESSION['prefix'] ."blogpost_comment", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}blogpost_comment (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,blogpost_id INT(8) NOT NULL,user_id INT(8) NOT NULL,date int(32),comment TEXT)"),		
				array("name" => $_SESSION['prefix'] ."user", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}user (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255) NOT NULL,username VARCHAR(255) NOT NULL,password VARCHAR(255) NOT NULL,rank INT(8),email VARCHAR(255),session int(8),reg_date int(11),visits INT(8),active INT(8),image VARCHAR(255))"),
				array("name" => $_SESSION['prefix'] ."page", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}page (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255) NOT NULL,url VARCHAR(255),visibility INT(8),parent INT(8),queue INT(8),page TEXT,image VARCHAR(255))"),
				array("name" => $_SESSION['prefix'] ."user_rank", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}user_rank (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255) NOT NULL,permission INT(8),rights TEXT)"),
				array("name" => $_SESSION['prefix'] ."visits", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}visits (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,date int(32) NOT NULL,ip INT(8), hostname VARCHAR(255))"),
				array("name" => $_SESSION['prefix'] ."plugin", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}plugin (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name varchar(255),dir varchar(255),area INT(4),permission int(11),table_name varchar(255),active int(11) DEFAULT 0)"),				

				);*/




?>






