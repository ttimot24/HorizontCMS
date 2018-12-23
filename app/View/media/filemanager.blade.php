<div id="filemanager">
  {{ csrf_field() }}
<section class='container'>

  <section  class='row'>

  <div class='col-md-4'>
    <h2>File manager</h2>
  </div>

  <div class='col-md-8 text-right' style='padding-top:15px;'>
    <a class='btn btn-primary' data-toggle='modal' data-backdrop='static' data-target='.upload_file_to_storage'><i class="fa fa-upload" aria-hidden="true"></i> Upload</a>
    <a class='btn btn-primary' data-toggle='modal' data-backdrop='static' data-target='.new_folder'><i class="fa fa-folder" aria-hidden="true"></i> Create Folder</a>
  </div>

  </section>

<div class='panel panel-default col-md-2' style='padding:0px;'>
 <ul class="list-group">
  <a href='admin/file-manager?path=images'><li class="list-group-item">images</li></a>
  <li class="list-group-item">uploads</li>
  <li class="list-group-item">themes</li>
  <li class="list-group-item">plugins</li>
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

                <div class='folder col-md-2' v-for="folder in folders" :id="folder" v-on:dblclick="open(folder);" >
                  
                  <div class="file-nav text-right">
                    <a v-on:click="modal(folder)" ><i class="fa fa-trash pull-right"></i></a>
                  </div>

                  <img src='resources/images/icons/dir.png' >
                  <b>@{{folder}}</b>
                </div>



                <div v-for="file in files" class='file col-md-2' :id="file"   @if($mode=='embed') v-on:click="returnFileUrl('storage/'+currentDirectory+'/'+file);" @endif >
                <div class="file-nav text-right">
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
                  "<div style='color:black;'><b>".trans('actions.delete_this',['content_type'=>'dir']).": </b> [dir_name_sample] <b>?</b></div>",
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


</div>

<script src="resources/assets/js/filemanager.js"></script>