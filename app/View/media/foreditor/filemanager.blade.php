<html>
<head>
  <base href="{{ Config::get('app.url') }}" />
  <title>{{ $title }} - {{ Config::get('app.name') }}</title>
  <link rel="shortcut icon" type="image/png" href="resources/images/icons/favicon16.png"/>

  @foreach ($css as $each_css)
      <link rel="stylesheet" type="text/css" href="{{url($each_css)}}">
  @endforeach

  @foreach ($js as $each_js)
        <script type="text/javascript" src="{{url($each_js)}}"></script>
  @endforeach

</head>
<body>
<section class='container'>

  <section class='row'>

  <div class='col-md-4'>
    <h2>File manager</h2>
  </div>

  <div class='col-md-8' style='text-align:right;padding-top:15px;'>
    <a class='btn btn-primary' data-toggle='modal' data-target='.upload_file_to_storage'><i class="fa fa-upload" aria-hidden="true"></i></a>
    <a class='btn btn-primary' data-toggle='modal' data-target='.new_folder'><i class="fa fa-folder" aria-hidden="true"></i></a>
  </div>

  </section>

<div class='panel panel-default col-md-2' style='padding:0px;'>
 <ul class="list-group">
  <a href='admin/filemanager?path=/images'><li class="list-group-item">images</li></a>
  <li class="list-group-item">uploads</li>
  <li class="list-group-item">themes</li>
  <li class="list-group-item">plugins</li>
</ul>
</div>


<div class="panel panel-default col-md-10" >
  <div class="panel-body">
      <ol class="breadcrumb">
			  <li><a href="admin/filemanager?path=">root</a></li>
			  <li><a><?= str_replace("/","</a></li><li><a>",$current_dir) ?></a></li>
			</ol>

            <?php	foreach($files as $file): ?>
            		<div class='file col-md-2' style='overflow:hidden;height:140px;cursor:pointer;' ondblclick=" window.location.href = 'admin/filemanager?path=<?= $old_path.'/'.$file ?>' ">
            
            <?php	$file_parts = pathinfo($file);

            		if(is_dir($current_dir.DIRECTORY_SEPARATOR.$file)){
            			echo Html::img('resources/images/icons/dir.png',"style='width:100%;'  ");
            		}
            		else if(isset($file_parts['extension']) && in_array($file_parts['extension'],$allowed_extensions['image'])){
            			echo Html::img($current_dir."/".$file,"style='object-fit:cover;width:100%;height:100px;' data-toggle='modal' data-target='.".$file."-modal-xl' ");

                 // Bootstrap::image_details($file,$current_dir."/".$file);
            		}else{
                  echo Html::img('resources/images/icons/file.png',"style='object-fit:cover;width:100%;height:100px;margin-bottom:15px;' ondblclick='' ");
                }
            		echo "<center><b>".$file."</b></center><br>";
            		echo "</div>";
            	
            ?>

            <?php endforeach; ?>

  </div>
</div>

</section>


<style>

	.list-group-item:hover{
		border-radius: 0px;
		color:white;
		background-color: #337ab7;	
	}

	.file:hover{
		border-radius:3px;
		color:white;
		background-color: #337ab7;
	}
</style>


</body>
</html>