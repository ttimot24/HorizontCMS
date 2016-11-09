@extends('layout')

@section('content')
<div class='container main-container'>

<div class='col-md-10'>
  <h1>{{trans('theme.themes')}}</h1>
</div>

<div class='col-md-2'>
  <br>
  <a id='upl' class='btn btn-primary' data-toggle='modal' data-target='.upload_theme'><i class='fa fa-upload'></i>&nbsp{{trans('theme.upload_theme_button')}}</a>
</div>




<div class='col-md-12'>
</br><br>
<div class='jumbotron' style='padding:2%;padding-left:3%;background-color:#31708F;color:white;'></br>
<div class='row'>
  <div class='col-xs-12 col-md-5'>
    <div class='thumbnail'>
      <img src="{{$active_theme->getImage()}}" />
    </div>
  </div>
  <div class='col-xs-12 col-md-7'>
    <h1>
        {{ $active_theme->getName() }}
        <small>{{trans('theme.version')}}: {{ $active_theme->getInfo('version') }}</small>
    </h1>
    <h4>{{trans('theme.is_the_current_theme')}}</h4>
    <p>{{ $active_theme->getInfo('description') }}</p>
    <p style='font-size:15px;'>{{trans('theme.author')}}: {{ $active_theme->getInfo('author') }} | {{trans('theme.website')}}: <a target='_blank' href='<?= UrlManager::http_protocol( $active_theme->getInfo('author_url') ); ?>'>{{ $active_theme->getInfo('author_url') }}</a></p>
  </div>
</div>
</div>


<h3 style='padding-left:15px;'>{{trans('theme.all')}}: {{$all_themes->count()}}</h3>




<div class="row">

<?php 

foreach($all_themes as $theme): ?>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src='<?= $theme->getImage() ?>' alt="..." style='width:100%;height:180px;'>
      <div class="caption">
        <h3><?= $theme->getInfo('name'); ?>
        </h3>
         <p>version: <?= $theme->getInfo('version'); ?> | author: <?= $theme->getInfo('author') ?></p>
        <p>
            <a href='admin/theme/set/<?=  $theme->root_dir ?>' class="btn btn-primary" role="button">Set theme</a> 
            <a href="#" class="btn btn-default" role="button" data-toggle='modal' data-target='.<?=  $theme->root_dir ?>-modal-xl'>Preview</a>
            <a href="#" class="btn btn-warning" role="button" disabled>{{ trans('actions.edit') }}</a>
            <button class='btn btn-danger' data-toggle='modal' data-target='.delete_<?= $theme->root_dir ?>' <?php if($all_themes->count()==1){echo "disabled";} ?> >{{ trans('actions.delete') }}</button>
        </p>
      </div>
    </div>
  </div>


<?php   Bootstrap::delete_confirmation(
    "delete_".$theme->root_dir,
    trans('actions.are_you_sure'),
    "<b>Delete this theme: </b>". $theme->getInfo('name')." <b>?</b>",
    "<a href='admin/theme/delete/". $theme->root_dir."' type='button' class='btn btn-danger'>
    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
    );

?>

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
        <button type='submit' class='btn btn-primary'>{{trans('actions.upload')}}</button></form>
        <button type='button' class='btn btn-default' data-dismiss='modal'>{{trans('actions.cancel')}}</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
