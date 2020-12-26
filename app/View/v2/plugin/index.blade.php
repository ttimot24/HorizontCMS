@extends('layout')

@section('content')
<div class='container main-container'>


<section class="row">
  <h1 class="col-sm-12 col-md-6">Plugin manager</h1> 

  <div class='col-sm-12 col-md-6 text-right'><br>
    <a href="{{config('horizontcms.backend_prefix')}}/plugin/onlinestore" class='btn btn-info'><i class="fa fa-cloud-download" aria-hidden="true"></i> Download apps</a>
    <a id='upl' class='btn btn-primary' data-toggle='modal' data-target='.upload_plugin' @if(!$zip_enabled) disabled @endif ><i class='fa fa-upload'></i>&nbspUpload new plugin</a>
  </div>
</section>



<div class='list-group'>

<?php

foreach($all_plugin as $current_plugin){

  echo  "<div class='list-group-item bg-dark' style='height:120px;padding-top:17px;border-bottom:3px solid black;'>";
  	echo "<div class='row'>";
      echo "<div class='col-md-10 col-sm-8 col-xs-8'>";

       echo Html::img($current_plugin->getIcon(),"class='img img-thumbnail pull-left' style='border-radius:5px;width:80px;height:80px;margin-right:10px;'");

        echo "<h4 class='list-group-item-heading'>";

            if($current_plugin->isActive()){
              echo "<a class='color-primary' id='".$current_plugin->root_dir."' href='".config('horizontcms.backend_prefix')."/plugin/run/".$current_plugin->getSlug()."'>".$current_plugin->getName()."</a>";
            }else{
              echo "<a class='color-primary' id='".$current_plugin->root_dir."' >".$current_plugin->getName()."</a>";
            }


         echo  " <small class='text-muted'>version: ".$current_plugin->getInfo('version')." | author: <a href='".$current_plugin->getInfo('author_url')."'>".$current_plugin->getInfo('author')."</a></small></h4>

            <p class='list-group-item-text text-white' style='margin-bottom:8px;margin-right:70px;'>".$current_plugin->getInfo('description')."</p>";

        echo "</div>";


        echo "<div class='col-md-2 col-sm-4 col-xs-4'>";
         
          if(!$current_plugin->isInstalled()){
              echo "<a id='install' class='btn btn-primary btn-block' href='".config('horizontcms.backend_prefix')."/plugin/install/".$current_plugin->root_dir."'>Install</a>";
          }
          else{
              if(!$current_plugin->isActive()){
                echo "<a class='btn btn-success btn-block' href='".config('horizontcms.backend_prefix')."/plugin/activate/".$current_plugin->root_dir."'>Activate</a>";
              }else{
                echo "<a class='btn btn-info btn-block' href='".config('horizontcms.backend_prefix')."/plugin/deactivate/".$current_plugin->root_dir."'>Deactivate</a>";
              }
          }
          echo "<button class='btn btn-danger btn-block' data-toggle='modal' data-target='.delete_".$current_plugin->root_dir."' >Delete</button>";

         echo "</div>";

      echo '</div>';

      echo "</div>";


   Bootstrap::delete_confirmation(
    "delete_".$current_plugin->root_dir,
    "Are you sure?",
    "<b>Delete this plugin: </b>".$current_plugin->getName()." <b>?</b>",
    "<a href='".config('horizontcms.backend_prefix')."/plugin/delete/".$current_plugin->root_dir."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>"
    );


       
}

?>


</div>


<div class='modal upload_plugin' id='create_file' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary bg-primary'>
        <h4 class='modal-title text-white'>New file</h4>
        <button type='button' class='close  text-white' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
      </div>
      <div class='modal-body'>

<form action="{{config('horizontcms.backend_prefix')}}/plugin/upload" method='POST' enctype='multipart/form-data'>
{{ csrf_field() }}
<div class='form-group'>
      <label for='file'>Upload file:</label>
      <input name='up_file[]' id='input-2' type='file' class='file' accept='.zip' multiple='true' data-show-upload='false' data-show-caption='true'>
    </div>


      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>Upload</button></form>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



</div>
@endsection
