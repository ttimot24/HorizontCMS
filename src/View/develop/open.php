<div class='container main-container'>

<?php 

echo "<h3><b>Theme:</b> " .$data['current_theme'] ."</h3></br>";	
echo "<section class='row'>";
echo "<div class='col-md-3'>";


echo "</br>
        <div class='col-sm-12'>
          <div class='panel panel-primary'>
            <div class='panel-heading'>
              <h3 class='panel-title'><b>Project files</b></h3>
            </div>
            <div class='panel-body'><font size='3'>";
       

      foreach($data['files'] as $each){

      	echo " <a href='admin/develop/opentheme/".$data['current_theme']."/".$each." '>" .$each ."</a></br>";
    

      }

  echo    "</font></div>
          </div>
          <a type='button' class='btn btn-link' data-toggle='modal' data-target='.create_file'><span class='glyphicon glyphicon-asterisk' aria-hidden='true'></span> New File</a>
        </div>";


echo "</div>";


echo "<div class='col-md-9'>";
echo "<ul class='nav nav-tabs'>
  <li role='presentation' class='active'><a href=''>" .$data['opened_file_name'] ."</a></li>
  <!--<li role='presentation'><a href=''>Preview</a></li>-->
  <li role='presentation'><div id='chars' style='padding:15px;'>0</div></li>

  <div style='text-align:right;'>";

 echo "<form method='post' action='admin/develop/savefile/".$data['current_theme']."/".$data['opened_file_name']."'>

 <button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Save File </button>
 </div>
</ul>";






echo Html::jsFile("resources/assets/code_editor/ace/ace.js");
echo Html::jsFile("resources/assets/code_editor/ace/theme-twilight.js");
echo Html::jsFile("resources/assets/code_editor/ace/mode-ruby.js'");
echo Html::jsFile("resources/assets/code_editor/jquery-ace.min.js");

echo "<textarea class='my-code-area' id='file_content' onKeyPress='alert('heey');' name='file_content' rows='35' cols='115' style='background-color:#1C1C1C;color:#FFBF00;font-size:13px;'>".$data['opened_file']."</textarea></br></br>";


print "
<script>
  $('.my-code-area').ace({ theme: 'twilight', lang: 'ruby' })
</script>";


print "
<script>
i = 0;
$(document).ready(function(){
    $('textarea').keypress(function(){

		        $('#chars').text(i += 1);
		        i++;
          
    });
});
</script>";

/*
}
else{

echo "<td>";
echo "<ul class='nav nav-tabs'>
  <li role='presentation' ><a href='".$_SYSTEM->base."?page=develop_theme&open=".$_GET['open']."&file=".$_GET['file']."&action=edit'>" .$_GET['file'] ."</a></li>
  <li role='presentation' class='active'><a href='".$_SYSTEM->base."?page=develop_theme&open=".$_GET['open']."&file=".$_GET['file']."&action=preview'>Preview</a></li>
  <!--<li role='presentation'><a href='#'>Messages</a></li>-->
  
  <div style='text-align:right;'>";

 echo "<form method='post' action='".$_SYSTEM->base."?page=develop_theme&open=".$_GET['open']."&file=".$_GET['file']."&action=save'>
 <button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Save File</button>
 </div>
</ul>";




$myfile = fopen("themes/" .$_GET['open'] ."/" .$_GET['file'], "r");

echo "<div id='file_content' name='file_content' style='width:950px;;min-height:500px;border:solid 1px;border-color:grey;'>";
$file = fread($myfile,filesize("themes/{$_GET['open']}/{$_GET['file']}"));
$file = str_replace("<?php","",$file);
$file = str_replace("?>","",$file);
$file = str_replace("href='","href='themes/".$_GET['open'] ."/",$file);
$file = str_replace("src='","src='themes/".$_GET['open'] ."/",$file);

eval($file);
print "</div></br></br>";
fclose($myfile);
}
*/






echo "</form>";
echo "</div>";
echo "</section>";


?>
</div>


<div class='modal create_file' id='create_file' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>New file</h4>
      </div>
      <div class='modal-body'>
        <form class='form-horizontal' role='form' action='admin/develop/createfile/<?= $data["current_theme"] ?>' method='POST'>
        <div class='form-group'>
        </br>
          <label class='control-label col-sm-3' for='pwd'>File name:</label>
          <div class='col-sm-5'>          
            <input type='text' name='file_name' class='form-control' id='pwd' placeholder='Enter file name' required>
          </div>
          <div class='col-sm-3'>
            <select class='form-control' id='sel1' name='select_extension'>
              <option value='txt'>txt</option>
              <option value='html'>html</option>
              <option value='css'>css</option>
              <option value='php'>php</option>
              <option value='js'>js</option>
            </select>
         </div>
        </div>


      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>Create file</button></form>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->