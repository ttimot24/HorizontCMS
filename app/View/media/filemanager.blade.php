<div id="filemanager" data-start="{{$current_dir}}" >

@csrf

  <file-manager></file-manager>

    @include('confirm_delete', [
          "route" => route('filemanager.destroy',['filemanager' => 'sample']),
          "id" => "delete_sample",
          "header" => trans('actions.are_you_sure'),
          "name" => "[dir_name_sample]",
          "content_type" => "dir",
          "delete_text" => trans('actions.delete'),
          "cancel" => trans('actions.cancel')
          ]
    )

<div class='modal upload_file_to_storage' id='upload_file_to_storage' tabindex='-1' role='dialog' aria-labelledby='upload_file_to_storage' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary bg-primary'>
        <h4 class='modal-title text-white'>Upload file</h4>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>

   <form action="{{ route('filemanager.store') }}" method='POST' enctype='multipart/form-data' v-on:submit.prevent="upload">
      <div class='modal-body'>


      <div class='form-group'>
        <label for='file'>Upload file:</label>
        <input name='up_file[]' id='input-2' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true' required>
      </div>

      </div>
      <div class='modal-footer'>
        <button type='submit' class='btn btn-primary'>{{ trans('actions.upload') }}</button>
        <button type='button' class='btn btn-default' data-bs-dismiss='modal'>{{ trans('actions.cancel') }}</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class='modal new_folder' id='new_folder' tabindex='-1' role='dialog' aria-labelledby='new_folder' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary bg-primary'>
        <h4 class='modal-title text-white'>Create new folder</h4>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
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
          <button type='button' class='btn btn-default' data-bs-dismiss='modal'>{{ trans('actions.cancel') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>



<div class='modal rename_modal' id='rename_sample' tabindex='-1' role='dialog' aria-labelledby='rename_file' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <h4 class='modal-title'>Rename</h4>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>

      <form action='admin/file-manager/rename' method='POST' v-on:submit.prevent="renameFile">
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
        <button type='button' class='btn btn-default' data-bs-dismiss='modal'>{{ trans('actions.cancel') }}</button>
      </div>
      </form>
    </div>
  </div>
</div>


</div>
