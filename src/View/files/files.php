<div class='container main-container'>

<div class='col-md-6'>
<h1>File Manager</h1>
</div>

<div class='col-md-6'>
<br>
<div class='pull-right'>
<form class='form-inline' action='' method='POST'>
  <div class='form-group'>
    <label class='sr-only' for='exampleInputAmount'></label>
    <div class='input-group'>
      <div class='input-group-addon'><span class='glyphicon glyphicon-search' aria-hidden='true'></span></div>
      <input type='text' class='form-control' name='search' id='exampleInputAmount' placeholder='Search for files or directories.' required>
    </div>
  </div>
  <button type='submit' class='btn btn-primary'>Search</button>
</form></div>
</div>


<div class='container'>
 <table class='table table-bordered'>
    <thead>
      <tr>
      	<th>Icon</th>
        <th>Name</th>
        <th>Extension</th>
		    <th>Size</th>
        <th>Creation date</th>
      </tr>
    </thead>
    <tbody>

<?php
foreach($data['files'] as $each){

  	print "<tr>";
  		if(is_dir($data['current_dir'].$each->name)){
  		 print "<td><img src='images/icons/dir.png' width='50'></td>";
  		
		 print "<td><a href='admin/filemanager/dir/".$data['current_dir'].$each->name."'>" .$each->name ."</a></td>";
		 print "<td>" .$each->extension ."</td>";
		 print "<td>" .number_format($each->size/1024,2) ." kB</td>";
		 print "<td>" .date("Y.m.d H:i:s.",$each->creation_time) ."</td>";
		 
	print "</tr>";

		}
}


$image_extensions = array("jpg", "JPG", "jpeg", "JPEG","png","gif");
$music_extensions = array("mp3", "ogg", "wav", "flac");

foreach($data['files'] as $each){



  	print "<tr>";
  		if(!is_dir($data['current_dir'].$each->name)){

  		if(in_array($each->extension,$image_extensions)){	
  		 print "<td><center><img src='".$data['current_dir'].$each->name."' width='50'></center></td>";
  		}
      else if(in_array($each->extension,$music_extensions)){ 
          print "<td><center><img src='images/icons/mp3.png' width='50'></center></td>"; 
      }
  		else{
  			print "<td><center><img src='images/icons/file.png' width='50'></center></td>";	
  		}

  		 $name_e = explode(".",$each->name);

		 print "<td> 
		 	<button type='button' class='btn btn-link' data-toggle='modal' data-target='.".$name_e[0]."-modal-xl'>" .$each->name ."</button>
		 		</td>";

		 print "<td>" .$each->extension ."</td>";
		 print "<td>" .number_format($each->size/1024,2) ." kB</td>";
		 print "<td>" .date("Y.m.d - H:i:s.",$each->creation_time) ."</td>";
		 
	print "</tr>";
		
print "

<div class='modal ".$name_e[0]."-modal-xl' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>

        <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
        <h2 class='modal-title'><center>".$each->name."</center></h2>
         </div>
        <div class='modal-body'>
           <center>";
        if(strpos($each->name,'.txt') || strpos($each->name,'.php') || strpos($each->name,'.css') || strpos($each->name,'.js')){
        	$str = readfile(getcwd()."/".$each->name);
        	$str = grab($str);
        	print $str;
        }
        else if( strpos($each->name,'.mp3') || strpos($each->name,'.wav') ){

          echo "<link href='//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css' rel='stylesheet'>
              <link href='plugins/default/music_player/css/bootstrap-player.css' rel='stylesheet'>";

          echo "<audio controls>
                  <source src='{$_GET['dir']}".$each->name ."' />
                </audio>";
         
        echo "<script src='//raw.github.com/fryn/html5slider/master/html5slider.js'></script>
              <script src='plugins/default/music_player/js/bootstrap-player.js'></script>";


        }else{   	
        print "<img src='".$data['current_dir'].$each->name ."' style='max-width:100%'/>";
        }
        print "</center>
        </div>


    </div>
  </div>
</div>";



		}
}

?>


    </tbody>
  </table>
</div>

</div>