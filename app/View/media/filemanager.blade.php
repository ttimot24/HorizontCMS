<div id="filemanager" data-start="{{$current_dir}}" >
  {{ csrf_field() }}
<section class='container'>

  <section  class='row'>

  <div class='col-md-4'>
    <h1>File manager</h1>
  </div>

  <div class='col-md-8 text-right' style='padding-top:25px;'>
    <div class="col-md-4 col-md-offset-3 col-sm-7 col-xs-7">
        <input type="text" v-model="filter" class="form-control" id="filter" placeholder="Filter">
    </div>
    <a class='btn btn-primary' data-toggle='modal' data-backdrop='static' data-target='.upload_file_to_storage'><i class="fa fa-upload" aria-hidden="true"></i> Upload</a>
    <a class='btn btn-primary' data-toggle='modal' data-backdrop='static' data-target='.new_folder'><i class="fa fa-folder" aria-hidden="true"></i> Create Folder</a>
  </div>

  </section>

<div class='panel panel-default col-md-2' style='padding:0px;padding-top: 10px;'>
 <h4 class="container">Drivers</h4>
 <ul class="list-group">
   @foreach(config('filesystems.disks') as $key => $value)
        <a href="#" v-on:click.prevent="open('{{ isset($value['root'])? basename($value['root']) : ''}}',false);"><li class="list-group-item">{{$key}}</li></a>
   @endforeach
</ul>
</div>

<div class="panel panel-default col-md-10" >
  <div class="panel-body">
      <div class="row">
        <div class="col-md-10">
        <ol class="breadcrumb text-left" style="margin-bottom:0px;padding-bottom:0px;">
          <li><a href="storage" v-on:click.prevent="open('',false);" >storage</a></li>
  			  <li v-for="(bcrumb) in breadcrumb"><a :href="bcrumb.link" v-on:click.prevent="open(bcrumb.link,false);" >@{{bcrumb.text}}</a></li>
  			</ol>
        </div>
        <div class="col-md-2 text-right">
          <a href="a" v-on:click.prevent="open(currentDirectory,false);"><i class="fa fa-refresh" onclick="$(this).addClass('fa-spin');" aria-hidden="true" style="font-size: 22px;margin:7px;margin-bottom: 0px;"></i></a>
        </div>
      </div>
      <hr>

      <div id="workspace" class="col-md-12">

                <div class='folder col-md-2 col-sm-4 col-xs-4' v-for="folder in folders" :id="folder" v-on:click="select(folder)" v-on:dblclick="open(folder);" >
                  
                  <div class="file-nav text-right">
                  <!--  <a v-on:click="renameModal(folder)"><i class="fa fa-pencil pull-right"></i></a> -->
                    <a v-on:click="deleteModal(folder)" ><i class="fa fa-trash pull-right"></i></a>
                  </div>

                  <img src='resources/images/icons/dir.png' >
                  <b>@{{folder}}</b>
                </div>



                <div v-for="file in files" class='file col-md-2 col-sm-4 col-xs-4' :id="file"   @if($mode=='embed') v-on:click="returnFileUrl('storage/'+currentDirectory+'/'+file);" @else v-on:click="select(file)" @endif >
                <div class="file-nav text-right">
                  <a v-on:click="renameModal(file)"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp
                  <a :href="'storage/'+currentDirectory+'/'+file"><i class="fa fa-download"></i></a>&nbsp
                  <a v-on:click="modal(file)" ><i class="fa fa-trash"></i></a>
                </div>
                 <img v-if="isKnownExtension(file)" :src="'storage/'+currentDirectory+'/'+file" />
                 <img v-else src="resources/images/icons/file.png" style='margin-bottom:5px;' />
                  <b>@{{file}}</b>
                </div>


        </div>

  </div>
</div>

</section>

<?php 


                 Bootstrap::delete_confirmation(
                  "delete_sample",
                  trans('actions.are_you_sure'),
                  "<div style='color:black;'>".trans('actions.delete_this',['content_type'=>'dir']).": <b>[dir_name_sample]</b> ?</div>",
                  "<a type='button' class='btn btn-danger' v-on:click.prevent='deleteFile' data-file='[dir_path_sample]' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
                  <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
                  );

?>



<div class='modal upload_file_to_storage' id='upload_file_to_storage' tabindex='-1' role='dialog' aria-labelledby='upload_file_to_storage' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Upload file</h4>
      </div>

   <form action='admin/file-manager/fileupload' method='POST' enctype='multipart/form-data' v-on:submit.prevent="upload">
      <div class='modal-body'>


      <div class='form-group'>
        <label for='file'>Upload file:</label>
        <input name='up_file[]' id='input-2' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true' required>
      </div>

      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>Upload</button>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class='modal new_folder' id='new_folder' tabindex='-1' role='dialog' aria-labelledby='new_folder' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Create new folder</h4>
      </div>

      <form action='admin/file-manager/new-folder' method='POST' enctype='multipart/form-data' v-on:submit.prevent="newFolder">
      <div class='modal-body'>

      <div class='form-group'>
        <div class='form-group' >
         <label for='title'>Name:</label>  
          <input type='text' class='form-control' name='new_folder_name' placeholder='Enter folder name' required>
        </div>    
      </div>


      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>Create</button>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>



<div class='modal rename_modal' id='rename_sample' tabindex='-1' role='dialog' aria-labelledby='rename_file' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Rename</h4>
      </div>

      <form action='admin/file-manager/rename' method='POST'>
      <div class='modal-body'>

      <div class='form-group'>
        <div class='form-group' >
         <label for='title'>Selected:</label>  
          <input type='text' class='form-control' name='old_name' id="selected" disabled>
        </div>    
      </div>

      <div class='form-group'>
        <div class='form-group' >
         <label for='title'>New name:</label>  
          <input type='text' class='form-control' name='new_name' id="selected" required>
        </div>    
      </div>


      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>Rename</button>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
      </form>
    </div>
  </div>
</div>



</div>

<script src="resources/assets/js/filemanager.js"></script>
