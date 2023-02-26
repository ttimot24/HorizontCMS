@extends('layout')

@section('content')
<div class='container main-container'>


<section class="row">
  <h2 class="col-sm-12 col-md-6">Plugin manager</h2> 

  <div class='col-sm-12 col-md-6 text-right text-end pt-4'>
    <a href="{{config('horizontcms.backend_prefix')}}/plugin/onlinestore" class='btn btn-info'><i class="fa fa-cloud-download" aria-hidden="true"></i> Download apps</a>
    <a id='upl' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='.upload_plugin' @if(!$zip_enabled) disabled @endif ><i class='fa fa-upload'></i>&nbspUpload new plugin</a>
  </div>
</section>



<div class='list-group mt-4'>



@foreach($all_plugin as $current_plugin)

<?php 

  echo  "<div class='list-group-item bg-dark p-3'>";
  	echo "<div class='row p-0'>";
      echo "<div class='col-md-1 col-sm-12 col-xs-12 p-0 pl-3 text-center'>";

       echo Html::img($current_plugin->getIcon(),"class='img img-thumbnail mt-1' style='width: 70px; height: 70px;' ");

      echo "</div>";

        echo "<div class='col-md-9 m-0'>
            <h4 class='list-group-item-heading p-0'>";

            if($current_plugin->isActive()){
              echo "<a class='color-primary' id='".$current_plugin->root_dir."' href='".config('horizontcms.backend_prefix')."/plugin/run/".$current_plugin->getSlug()."'>".$current_plugin->getName()."</a>";
            }else{
              echo "<a class='color-primary' id='".$current_plugin->root_dir."' >".$current_plugin->getName()."</a>";
            }


         echo  " <small class='text-muted'>version: ".$current_plugin->getInfo('version')." | author: <a href='".$current_plugin->getInfo('author_url')."'>".$current_plugin->getInfo('author')."</a></small></h4>

            <p class='text-white'>".$current_plugin->getInfo('description')."</p>";

        echo "</div>";


        echo "<div class='col-md-2 col-sm-4 col-xs-4 text-end'>";
         
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
          echo "<button class='btn btn-danger btn-block' data-bs-toggle='modal' data-bs-target='#delete_".$current_plugin->root_dir."' >Delete</button>";

         echo "</div>";

      echo '</div>';

      echo "</div>";

?>

    @include('confirm_delete', [
          "route" => route('plugin.destroy',['plugin' => $current_plugin->root_dir]),
          "id" => "delete_".$current_plugin->root_dir,
          "header" => trans('actions.are_you_sure'),
          "name" => $current_plugin->getName(),
          "content_type" => "plugin",
          "delete_text" => trans('actions.delete'),
          "cancel" => trans('actions.cancel')
          ]
    )

@endforeach


</div>


<div class='modal upload_plugin' id='create_file' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary bg-primary'>
        <h4 class='modal-title text-white'>New file</h4>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>

<form action="{{config('horizontcms.backend_prefix')}}/plugin/upload" method='POST' enctype='multipart/form-data'>
@csrf
<div class='form-group'>
      <label for='file'>Upload file:</label>
      <input name='up_file[]' id='input-2' type='file' class='file' accept='.zip' multiple='true' data-show-upload='false' data-show-caption='true'>
    </div>


      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>Upload</button></form>
        <button type='button' class='btn btn-default' data-bs-dismiss='modal'>Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



</div>
@endsection
