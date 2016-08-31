<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
ini_set("DISPLAY_ERRORS","ON");

include("classes/system_messages.class.php");
include("classes/html.class.php");

if(isset($_POST['lang']) && $_POST['lang']!=""){
	$_SESSION['language']=$_POST['lang'];
}
if(isset($_POST['username']) && $_POST['username']!="" && isset($_POST['password']) && $_POST['password']!=""){
	$_SESSION['server'] = $_POST['server'];
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	$_SESSION['database'] = $_POST['database'];
	$_SESSION['prefix'] = $_POST['prefix'];
}
if(isset($_POST['ad_username']) && $_POST['ad_username']!="" && isset($_POST['ad_password']) && $_POST['ad_password']!=""){
	$_SESSION['ad_username'] = $_POST['ad_username'];
	$_SESSION['ad_password'] = $_POST['ad_password'];
	$_SESSION['ad_email'] = $_POST['ad_email'];
}


echo "<html>";
echo "<head>";

echo Html::title("Installing HorizontCMS");
echo Html::cssFile("bootstrap/css/bootstrap.min.css");
echo Html::cssFile("https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js");
echo Html::jsFile("bootstrap/js/bootstrap.min.js");
echo Html::cssFile("style.css");

echo "</head>";
echo "<body>";

if(!isset($_GET['step']) || $_GET['step']==""){

echo "<style>
p{
	margin:13px;
	font-size:12px;
}

</style>";


echo "<div class='container'>
  <div class='jumbotron'>

    <h1>HorizontCMS <small>by Timot</small></h1>      
    <p>The CMS that fit exactly to your needs.</p></br> 
    <p><a href='install.php?step=1'><button type='button' class='btn btn-primary btn-lg'>&nbsp&nbsp&nbspInstall HorizontCMS&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span></button></a></p>     
  </div>

<div class='row'>

  <div class='col-sm-6 col-md-4'><center>
      <span class='glyphicon glyphicon-pencil' aria-hidden='true' style='font-size:3em;'></span>
      <div class='caption'>
        <h3>Blogging</h3>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum</p>
      </div></center>
  </div>

  <div class='col-sm-6 col-md-4'><center>
      <span class='glyphicon glyphicon-user' aria-hidden='true' style='font-size:3em;'></span>
      <div class='caption'>
        <h3>User handling</h3>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum</p>
      </div></center>
  </div>

  <div class='col-sm-6 col-md-4'><center>
      <span class='glyphicon glyphicon-file' aria-hidden='true' style='font-size:3em;'></span>
      <div class='caption'>
        <h3>File handling</h3>
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum</p>
      </div>
  </div></center>
</div>

</div>";
}
else{

		echo "<div class='container'>
			  <div class='jumbotron'>
			  <h1><small>Installing HorizontCMS</small></h1>   ";




	switch($_GET['step']){

	case 1:	

			echo "
				<div class='progress'>
						  <div class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='min-width: 2em;'>
						    0%
						  </div>
					</div>
					<hr/>
					<h2>Step 1: Language</h2>
					</br>
					</br>
					<form action='install.php?step=2' role='form' method='POST'>
					    <div class='form-group'>
					      <label for='sel1'>Select language:</label>
					      <select class='form-control' id='sel1' name='lang'>
					        <option value='english'>English</option>
					        <option value='hungarian'>Magyar</option>
					        <option value='deutsch'>Deutsch</option>
					      </select>
					</br></br>
					<a href='install.php'><button type='button' class='btn btn-default btn-md'><span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span> Previous</button></a>
					<button type='submit' class='btn btn-primary btn-md'>&nbsp&nbspNext&nbsp&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp&nbsp</button>
					</form>
					</br>
					</br>
					
					";
  			break;


  	case 2:

  		isset($_SESSION['server']) ? : $_SESSION['server']="localhost";
  		isset($_SESSION['username']) ? : $_SESSION['username']="";
  		isset($_SESSION['password']) ? : $_SESSION['password']="";
  		isset($_SESSION['database']) ? : $_SESSION['database']="";
  		isset($_SESSION['prefix']) ? : $_SESSION['prefix']="";

  		echo "<div class='progress'>
						  <div class='progress-bar' role='progressbar' aria-valuenow='40' aria-valuemin='0' aria-valuemax='100' style='min-width: 35em;'>
						    40%
						  </div>
					</div>
					<hr/>


  		<h2>Step 2: Database</h2>
					</br>
					</br>";

		echo "<form action='install.php?step=3' method='POST'>";


			echo "<div class='container'>
			  
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='server'>Server:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='server' name='server' value='".$_SESSION['server']."'>
			      </div>
			    </div>
			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='username'>Username:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='username' name='username' placeholder='username' value='".$_SESSION['username']."'>
			      </div>
			    </div>

			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='pwd'>Password:</label>
			      <div class='col-sm-5'>          
			        <input type='password' class='form-control' id='pwd' name='password' placeholder='password' value='".$_SESSION['password']."'>
			      </div>
			    </div>

			  	</br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='data'>Create database:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='data' name='database' placeholder='database name' value='".$_SESSION['database']."'>
			      </div>
			    </div>

			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-2' for='prefix'>Table prefix:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='prefix' name='prefix' placeholder='prefix' value='".$_SESSION['prefix']."'>
			      </div>
			    </div>

			</div>
			</br>
			</br>
					<a href='install.php?step=1'><button type='button' class='btn btn-default btn-md'><span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span> Previous</button></a>
					<button type='submit' class='btn btn-primary btn-md'>&nbsp&nbspNext&nbsp&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp&nbsp</button>
					
						";
		echo "</form>";

  		break;


  	case 3:

  			isset($_SESSION['ad_username']) ? : $_SESSION['ad_username']="";
  			isset($_SESSION['ad_password']) ? : $_SESSION['ad_password']="";
  			isset($_SESSION['ad_email']) ? : $_SESSION['ad_email']="";

  	  		echo "<div class='progress'>
						  <div class='progress-bar' role='progressbar' aria-valuenow='80' aria-valuemin='0' aria-valuemax='100' style='min-width: 75em;'>
						    80%
						  </div>
					</div>
					<hr/>";

	/*		$conn = new MySqli($_SESSION['server'],$_SESSION['username'],$_SESSION['password']);

			$sys_message = new System_Messages();

			if(isset($conn->error)){
  				$sys_message->error("Can't connect to database!");
  			}else{
  				$sys_message->success("Successfully connected to database.");
  				$conn->close();
  			}*/

  			$sys_message = new System_Messages();


echo "
  		<h2>Step 3: Administrator</h2>
					</br>
					</br>";

				echo "<form action='install.php?step=4' method='POST'>";



				echo "<div class='container'>

				<div class='form-group'>
			      <label class='control-label col-sm-3' for='username'>Create username:</label>
			      <div class='col-sm-5'>          
			        <input type='text' class='form-control' id='username' name='ad_username' placeholder='username' value='".$_SESSION['ad_username']."'>
			      </div>
			    </div>

			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='pwd'>Create password:</label>
			      <div class='col-sm-5'>          
			        <input type='password' class='form-control' id='pwd' name='ad_password' placeholder='password' value='".$_SESSION['ad_password']."'>
			      </div>
			    </div>
			    

			    </br></br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='em'>Email:</label>
			      <div class='col-sm-5'>          
			        <input type='email' class='form-control' id='em' name='ad_email' placeholder='email' value='".$_SESSION['ad_email']."'>
			      </div>
			    </div>
			    </div>

			   	 </br>
					</br>
					<a href='install.php?step=2'><button type='button' class='btn btn-default btn-md'><span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span> Previous</button></a>
					<button type='submit' class='btn btn-primary btn-md'>&nbsp&nbspNext&nbsp&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>&nbsp&nbsp</button>
					
			    </div>
			    </form>";


		echo "	";
  		break;

  	case 4:
  	  	  		echo "<div class='progress'>
						  <div class='progress-bar' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='min-width: 85em;'>
						    100%
						  </div>
					</div>
					<hr/>

  		<h2>Step 4: Finish</h2>
					</br>
					</br>";

			echo "HorizontCMS was successfully installed!";



		$conn = new MySqli($_SESSION['server'],$_SESSION['username'],$_SESSION['password']);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
	

		$sql = "CREATE DATABASE IF NOT EXISTS " .$_SESSION['database'] ."";
		if ($conn->query($sql) === TRUE) {
		    echo "Database created successfully";
		} else {
		    echo "Error creating database: " . $conn->error;
		}
		$conn->close();

		$conn = new Mysqli($_SESSION['server'],$_SESSION['username'],$_SESSION['password'],$_SESSION['database']);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 


$all_create_sql_query = array(
				array("name" => $_SESSION['prefix'] ."settings" , "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}settings (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,setting VARCHAR(255),value TEXT,more INT(8),UNIQUE(setting))"),
				array("name" => $_SESSION['prefix'] ."socialmedia_settings", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}socialmedia_settings (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,social_media VARCHAR(255),link VARCHAR(255),more INT(8))"),
				array("name" => $_SESSION['prefix'] ."news", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}news (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,title VARCHAR(255) NOT NULL,summary VARCHAR(700),text TEXT,date int(11),author_id int(8),category int(8),image VARCHAR(255))"),
				array("name" => $_SESSION['prefix'] ."news_category", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}news_category (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,category_name VARCHAR(255))"),
				array("name" => $_SESSION['prefix'] ."news_comments", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}news_comments (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,news_id INT(8) NOT NULL,user_id INT(8) NOT NULL,comment_date int(32),comment TEXT)"),		
				array("name" => $_SESSION['prefix'] ."users", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}users (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255) NOT NULL,username VARCHAR(255) NOT NULL,password VARCHAR(255) NOT NULL,permission INT(8),email VARCHAR(255),session int(8),reg_date int(11),visits INT(8),active INT(8))"),
				array("name" => $_SESSION['prefix'] ."pages", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}pages (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name VARCHAR(255) NOT NULL,url VARCHAR(255),visibility INT(8),parent INT(8),parent_id INT(8),queue INT(8),page TEXT)"),
				array("name" => $_SESSION['prefix'] ."privilages", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}privilages (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,priv_name VARCHAR(255) NOT NULL,permission INT(8))"),
				array("name" => $_SESSION['prefix'] ."visits", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}visits (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,_date_ int(32) NOT NULL,ip INT(8))"),
				array("name" => $_SESSION['prefix'] ."plugins", "query" => "CREATE TABLE IF NOT EXISTS {$_SESSION['prefix']}plugins (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,name varchar(255),slug varchar(255),dir varchar(255),level varchar(255),permission int(11),status int(11) DEFAULT 0)"),				

				);


$all_insert_sql_query = array(
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'Title','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'SiteName','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'Slogan','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'Index','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'ScrollText','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'Contact','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'Language','".strtolower($_SESSION['language'])."',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'WebsiteType','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'Logo','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'AdminLogo','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}settings VALUES(default,'AdminTheme','',1)"),

				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia_settings VALUES(default,'facebook','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia_settings VALUES(default,'youtube','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia_settings VALUES(default,'instagram','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia_settings VALUES(default,'twitter','',1)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}socialmedia_settings VALUES(default,'soundcloud','',1)"),

				array("query" => "INSERT INTO {$_SESSION['prefix']}news VALUES(default,'Welcome you','This is a sample news for HorizontCMS.','If you see this post than the installation was successfull. Go to the admin area to edit or delete this post.',".time().",1,1,'none')"),

				array("query" => "INSERT INTO {$_SESSION['prefix']}users VALUES(default,'Administrator','" .$_SESSION['ad_username'] ."','".md5($_SESSION['ad_password'])."',6,'".$_SESSION['ad_email']."',1,".time().",0,1)"),

				array("query" => "INSERT INTO {$_SESSION['prefix']}privilages VALUES(default,'Public',0)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}privilages VALUES(default,'User',1)"),	
				array("query" => "INSERT INTO {$_SESSION['prefix']}privilages VALUES(default,'Member',2)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}privilages VALUES(default,'Editor',3)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}privilages VALUES(default,'Manager',4)"),
				array("query" => "INSERT INTO {$_SESSION['prefix']}privilages VALUES(default,'Admin',5)"),



	);



		foreach ($all_create_sql_query as $create_sql) {
			if ($conn->query($create_sql['query']) === TRUE) {
				    echo "<p style='color:green;font-size:15px;'>Table ".$create_sql['name']." created successfully</p>";
				} else {
				    echo "<p style='color:red;font-size:15px;'>Error creating ".$create_sql['name']." table: " . $conn->error ."</p>";
				}
		}


		foreach ($all_insert_sql_query as $insert_sql) {
			if(!$conn->query($insert_sql['query'])){
				echo "<p style='color:red;font-size:15px;'>Error inserting a row!</p>";
			}
		}




		$conn->close();



		if(!file_exists("core/config.php")){
		$myfile = fopen("core/config.php", "w") or die("Unable to open file!");

		$txt = 
		"<?php\n
		  DEFINE ('SERVER','" .$_SESSION['server'] ."');
		  DEFINE ('USERNAME','" .$_SESSION['username'] ."');
		  DEFINE ('PASSWORD','" .$_SESSION['password']."');
		  DEFINE ('DATABASE','" .$_SESSION['database'] ."');\n
		  DEFINE ('PREFIX','" .$_SESSION['prefix'] ."');\n
		?>";

		fwrite($myfile, $txt);
		fclose($myfile);
		}
		else{
		  echo "</br>File Exists";
		}



		echo "</br><a href='admin.php'><button type='button' class='btn btn-primary btn-md'>Finish & go to admin area <span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span></button></a>";
		session_destroy();
			break;

	case 5:
	
  	}
}



echo "	</div>
  			</div>";



echo "</body>";
echo "<footer>";
echo "</footer>";
echo "</html>";
?>