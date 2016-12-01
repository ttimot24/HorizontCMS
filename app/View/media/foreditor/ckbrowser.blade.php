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
  <a href='admin/filemanager/ckbrowse?path=/images'><li class="list-group-item">images</li></a>
  <li class="list-group-item">uploads</li>
  <li class="list-group-item">themes</li>
  <li class="list-group-item">plugins</li>
</ul>
</div>


<div class="panel panel-default col-md-10" >
  <div class="panel-body">
      <ol class="breadcrumb">
        <li><a href="admin/filemanager/ckbrowse?path=">root</a></li>
        <li><a><?= str_replace("/","</a></li><li><a>",$current_dir) ?></a></li>
      </ol>

            <?php foreach($files as $file): ?>
                <div class='file col-md-2' style='overflow:hidden;height:140px;cursor:pointer;' ondblclick=" window.location.href = 'admin/filemanager/ckbrowse?path=<?= $old_path.'/'.$file ?>&CKEditor=editor&CKEditorFuncNum=1&langCode=en' ">
            
            <?php $file_parts = pathinfo($file);

                if(is_dir($current_dir.DIRECTORY_SEPARATOR.$file)){
                  echo Html::img('resources/images/icons/dir.png',"style='width:100%;'  ");
                }
                else if(isset($file_parts['extension']) && in_array($file_parts['extension'],$allowed_extensions['image'])){

                  $full_path = $current_dir."/".$file;

                  echo Html::img($full_path,"style='object-fit:cover;width:100%;height:100px;' onclick='returnFileUrl(\"$full_path\")' ");

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







<div class='modal upload_file_to_storage' id='upload_file_to_storage' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Upload file</h4>
      </div>
      <div class='modal-body'>

      <form action='admin/filemanager/fileupload' method='POST' enctype='multipart/form-data'>
      {{ csrf_field() }}
      <div class='form-group'>
        <label for='file'>Upload file:</label>
        <input type='hidden' name='dir_path' value="{{ $current_dir }}">
        <input name='up_file[]' id='input-2' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true'>
      </div>


      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>Upload</button></form>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class='modal new_folder' id='new_folder' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Create new folder</h4>
      </div>
      <div class='modal-body'>

<form action='admin/filemanager/newfolder' method='POST' enctype='multipart/form-data'>
      {{ csrf_field() }}
<div class='form-group'>
      <input type='hidden' name='dir_path' value="{{ $current_dir }}">
      <div class='form-group' >
       <label for='title'>Name:</label>  
        <input type='text' class='form-control' name='new_folder_name' placeholder='Enter folder name' required>
      </div>    
    </div>


      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>Create</button></form>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
        // Helper function to get parameters from the query string.
        function getUrlParam( paramName ) {
            var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
            var match = window.location.search.match( reParam );

            return ( match && match.length > 1 ) ? match[1] : null;
        }
        // Simulate user action of selecting a file to be returned to CKEditor.
        function returnFileUrl(filepath) {

            var funcNum = getUrlParam( 'CKEditorFuncNum' );
            var fileUrl = filepath;
            window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
            window.close();
        }
    </script>

</html>