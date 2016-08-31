<div class='container main-container'>

<div class='jumbotron' style='padding-top:17px;height:200px;font-size:16px;'><center><h1 style='font-weight:bolder;'>HorizontCMS</br><i>Spread</i></h1></center></div>

<form action='admin/settings/spreadaction' method='POST'>

				<table><tbody><tr><td style='width:600px;'>
				<div class='form-group'>
			      <label class='control-label col-sm-3' for='server'>Server:</label>
			      <div class='col-sm-7'>          
			        <input type='text' class='form-control' id='server' name='server' placeholder='Target server name or ip' required>
			      </div>
			    </div>

			    </br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='username'>Username:</label>
			      <div class='col-sm-7'>          
			        <input type='text' class='form-control' id='username' name='ftp_user' placeholder='FTP username' required>
			      </div>
			    </div>

			    </br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='pwd'>Password:</label>
			      <div class='col-sm-7'>          
			        <input type='password' class='form-control' id='pwd' name='ftp_pass' placeholder='FTP password' required>
			      </div>
			    </div>

			    </br>
			    <div class='form-group'>
			      <label class='control-label col-sm-3' for='pwd'>Basedir</label>
			      <div class='col-sm-7'>          
			        <input type='text' class='form-control' id='pwd' name='ftp_basedir' placeholder='FTP basedirectory'>
			      </div>
			    </div>

			      <div class='form-group'>
			      <label class='control-label col-sm-3' for='db'>Include database</label>
			      <div class='col-sm-7'>          
			        <input type='checkbox' class='form-control' id='db' name='datab' value='1'>
			      </div>
			    </div>


			    </td>
			    <td>
			

			<button type='submit' class='btn btn-primary btn-lg'>Spread <span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span></button>
				</td></tr></tbody></table>	
				
</form>

<br><br>

</div>