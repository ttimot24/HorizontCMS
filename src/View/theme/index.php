<div class='container main-container'>

<div class='col-md-10'>
  <h1>Themes</h1>
</div>

<div class='col-md-2'>
  <br>
  <a id='upl' class='btn btn-primary' data-toggle='modal' data-target='.upload_theme'><i class='fa fa-upload'></i>&nbspUpload theme</a>
</div>




<div class='col-md-12'>
</br><br>
<div class='jumbotron' style='padding:2%;padding-left:3%;/*background-color:rgba(56,117,150,0.5);*/background-color:#31708F;color:white;'></br>
<div class='row'>
  <div class='col-xs-12 col-md-5'>
    <div class='thumbnail'>
      <img src=<?= $data['active']->image; ?> />
    </div>
  </div>
  <div class='col-xs-12 col-md-7'>
    <h1>
        <?= $data['active']->get_info('name'); ?>
        <small>version: <?= $data['active']->get_info('version') ?></small>
    </h1>
    <h4>is the currently active theme</h4>
    <p><?= $data['active']->get_info('description'); ?></p>
    <p style='font-size:15px;'>author: <?= $data['active']->get_info('author') ?> | website: <a target='_blank' href='<?= UrlManager::http_protocol($data['active']->get_info('author_url')); ?>'><?= $data['active']->get_info('author_url') ?></a></p>
  </div>
</div>
</div>


<h3 style='padding-left:15px;'>All: <?= count($data['all_theme']) ?></h3>




<div class="row">

<?php 

foreach($data['all_theme'] as $theme): ?>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src='<?= $theme->image ?>' alt="..." style='width:100%;height:180px;'>
      <div class="caption">
        <h3><?= $theme->get_info('name'); ?>
        </h3>
         <p>version: <?= $theme->get_info('version'); ?> | author: <?= $theme->get_info('author') ?></p>
        <p>
            <a href='admin/theme/set/<?=  $theme->dir_name ?>' class="btn btn-primary" role="button">Set theme</a> 
            <a href="#" class="btn btn-default" role="button" data-toggle='modal' data-target='.<?=  $theme->dir_name ?>-modal-xl'>Preview</a>
            <a href="#" class="btn btn-warning" role="button" disabled>Edit</a>
            <button class='btn btn-danger' data-toggle='modal' data-target='.delete_<?= $theme->dir_name ?>' <?php if(count($data['all_theme'])==1){echo "disabled";} ?> >Delete</button>
        </p>
      </div>
    </div>
  </div>


<?php   Bootstrap::delete_confirmation(
    "delete_".$theme->dir_name,
    "Are you sure?",
    "<b>Delete this theme: </b>". $theme->get_info('name')." <b>?</b>",
    "<a href='admin/theme/delete/". $theme->dir_name."' type='button' class='btn btn-danger'>
    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>"
    );

?>

<div class='modal <?=  $theme->dir_name ?>-modal-xl' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>

   	<div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
        <h2 class='modal-title'><center><?php 
  
                echo $theme->get_info('name'); 
                echo " <small>".$theme->get_info('version')."</small>";

            ?></center></h2>
    </div>
    <div class='modal-body'>
            
            <iframe src='admin/theme/preview/<?=  $theme->dir_name ?>' width='100%'  height='500px'></iframe>

    </div>

    </div>
  </div>
</div>






<?php endforeach; ?>

</div>
</div>

</div>




<div class='modal upload_theme' id='create_file' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>New file</h4>
      </div>
      <div class='modal-body'>

<form action='admin/theme/upload' method='POST' enctype='multipart/form-data'>
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


