<?php

echo "<div class='container' style='margin-left:20%;width:88%;'>";
echo "<div class='jumbotron' style='padding-top:17px;height:200px;font-size:16px;'><center><h1 style='font-weight:bolder;'>HorizontCMS</br><i>Spread</i></h1></center></div>";

echo System::$message->warning("Recommended to use Google Chrome browser to this function!");

if(!function_exists('fsockopen')) {
	echo System::$message->error("FTP is disabled on this server! Sorry we can't use the <i><b>Spread</b></i> function");
}
else {

if(@$_POST['server']!="" && @$_POST['ftp_user']!="" && @$_POST['ftp_pass']!=""){
	echo System::$message->success("FTP is enabled on this server!");

		$ftp_server = $_POST['server'];
		$ftp_username = $_POST['ftp_user'];
		$ftp_userpass = $_POST['ftp_pass'];


		$ftp_conn = ftp_connect($ftp_server);
		

		ftp_pasv($ftp_conn, true);
		$ftp_login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
		

		if($ftp_conn && $ftp_login){
			echo System::$message->success("Connection established with the FTP server!");
			

			$paths = $_SYSTEM->get_dir_map();

				print "<b>Local base directory: </b>" .getcwd();

				print "<table class='table'>    
						<thead>
					      <tr>
					        <th>Task</th>
					        <th><center>Status</center></th>
					      </tr>
					    </thead>
					    
					    <tbody>";

				foreach($paths as $each){
					print "<tr>";

					@$each_folder = str_replace($root, "" , $each);
					$server_folder = $_POST['ftp_basedir'] ."".$each_folder;					
					


					if (ftp_mkdir($ftp_conn, $server_folder)) {
						echo  "<tr class='success'><td><b>DIR:</b> " .$server_folder ."</td><td><center><img src='images/okey.png' width='20' ></center></td></tr>";
						} 
						else {
						echo  "<tr class='danger'><td><b>DIR:</b> " .$server_folder ."</td><td><center><img src='images/delx.png' width='15' ></center></td></tr>";
						}

					print "</tr>";

						$files = scandir($each);				

							foreach(array_slice($files,2) as $each_file){
									

										$local_file = $each."/".$each_file;
										
										$server_file = $server_folder."/".$each_file;


									if(@is_file($local_file) && @!strpos("config.php")){
										

									//	print "</br>Local file: " .$local_file ."</br>";
									//	print "Server file: " .$server_file ."</br></br>";

										@$upload = ftp_nb_put($ftp_conn, $server_file, $local_file, FTP_BINARY);


								while ($upload == FTP_MOREDATA){
									  $upload = ftp_nb_continue($ftp_conn);
									  }


								if ($upload != FTP_FINISHED){
								  	print "<tr class='danger'><td><b>FILE:</b> <i>" .$each_file ."</i>! </td><td><center><img src='images/delx.png' width='15' ></center></td></tr>";
								  }
								else{
									print "<tr class='success'><td><b>FILE:</b> <i>" .$each_file ."</i>! </td><td><center><img src='images/okey.png' width='20' ></center></td></tr>";
									}

							
								
								}

									unset($local_file);										
									unset($server_file);
										

							}

						
				} 

				print "</tbody></table>";
						ftp_close($ftp_conn);

			}
			else{
				echo System::$message->error("Communication failed with the FTP server!");
			}


		ftp_close($ftp_conn); 






	}
	else{

			  
	echo		"<form action='".$_SYSTEM->base."?page=settings&sub=spread' method='POST'>

				<table><tbody><tr><td style='width:600px;'>
				<div class='form-group'>
			      <label class='control-label col-sm-3' for='server'>Server:</label>
			      <div class='col-sm-7'>          
			        <input type='text' class='form-control' id='server' name='server' placeholder='Server name or ip'>
			      </div>
			    </div>

			    </br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='username'>Username:</label>
			      <div class='col-sm-7'>          
			        <input type='text' class='form-control' id='username' name='ftp_user' placeholder='FTP username'>
			      </div>
			    </div>

			    </br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='pwd'>Password:</label>
			      <div class='col-sm-7'>          
			        <input type='password' class='form-control' id='pwd' name='ftp_pass' placeholder='FTP password'>
			      </div>
			    </div>

			    </br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='pwd'>Basedir</label>
			      <div class='col-sm-7'>          
			        <input type='text' class='form-control' id='pwd' name='ftp_basedir' placeholder='FTP basedirectory'>
			      </div>
			    </div>

			    </td>
			    <td>
			

			<button type='submit' class='btn btn-primary btn-lg'>Spread <span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span></button>
				</td></tr></tbody></table>	
				
		</form>";




	}


}

echo "</div>";
?>