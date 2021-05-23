@extends('layout')

@section('content')
<div class='container'>

 <div class="row">
      <div class='col-md-8'>
        <h1>{{trans('theme.themes')}}</h1>
      </div>

      <div class='col-md-4 my-auto text-right text-end'>
        <a href="admin/theme/onlinestore" class='btn btn-info'><i class="fa fa-cloud-download" aria-hidden="true"></i> Download themes</a>
        <a id='upl' class='btn btn-primary' data-toggle='modal' data-target='.upload_theme'><i class='fa fa-upload'></i>&nbsp{{trans('theme.upload_theme_button')}}</a>
      </div>
 


<div class='col-md-12'>
  <div class='jumbotron' style='background-color:#31708F;'>
    <div class='row'>
      <div class='col-xs-12 col-md-5'>
        <div class='thumbnail pt-4'>
          <img class="img img-thumbnail w-100" src="{{$active_theme->getImage()}}" />
        </div>
      </div>
      <div class='col-xs-12 col-md-7'>
        <h1>{{ $active_theme->getName() }}</h1>
        <h4 class="text-muted">{{trans('theme.version')}}: {{ $active_theme->getInfo('version') }}</h4>
        <h4>{{trans('theme.is_the_current_theme')}}</h4>
        <p>{{ $active_theme->getInfo('description') }}</p>
        @if($active_theme->getSupportedLanguages()->count() > 0)
          <p style='font-size:15px;'>{{trans('theme.supported_lang') }}: {{implode(', ',$active_theme->getSupportedLanguages()->toArray())}}</p>
        @endif
        <p style='font-size:15px;'>{{trans('theme.author')}}: {{ $active_theme->getInfo('author') }} | {{trans('theme.website')}}: <a target='_blank' href='<?= UrlManager::http_protocol( $active_theme->getInfo('author_url') ); ?>'>{{ $active_theme->getInfo('author_url') }}</a></p>
      </div>
    </div>
  </div>


<div class='row'>
  <h3>{{trans('theme.all')}}: {{$all_themes->count()}}</h3>
</div>



  <?php foreach($all_themes as $theme): ?>

  <div class="card col-sm-6 col-md-4 mb-2 float-left float-start p-2 bg-dark">
    <img class="card-img-top" src="<?= $theme->getImage() ?>" style="height:180px;" alt="Theme screenshot">
    <div class="card-body text-white">
    <h3><?= $theme->getName(); ?></h3>
          <p>version: <?= $theme->getInfo('version'); ?> | author: <?= $theme->getInfo('author') ?></p>
          <p class="mb-0">
              <a href='admin/theme/set/<?=  $theme->root_dir ?>' class="btn btn-primary <?php if($theme->isCurrentTheme()){ echo 'disabled'; } ?> " role="button">Activate</a> 
              <!--<a href="#" class="btn btn-default" role="button" data-toggle='modal' data-target='.<?=  $theme->root_dir ?>-modal-xl'>Preview</a>-->
              <a href='admin/theme/options/<?=  $theme->root_dir ?>'  class="btn btn-warning" role="button">{{ trans('actions.options') }}</a>
              <button class='btn btn-danger' data-toggle='modal' data-target='.delete_<?= $theme->root_dir ?>' <?php if($all_themes->count()==1){echo "disabled";} ?> >{{ trans('actions.delete') }}</button>
          </p>
    </div>
  </div>

  <!--  <div class="col-sm-6 col-md-4 bg-dark">
      <div class="thumbnail py-3">
        <img src='<?= $theme->getImage() ?>' alt="..." style='width:100%;height:180px;'>
        <div class="caption text-white">
          <h3><?= $theme->getName(); ?></h3>
          <p>version: <?= $theme->getInfo('version'); ?> | author: <?= $theme->getInfo('author') ?></p>
          <p class="mb-0">
              <a href='admin/theme/set/<?=  $theme->root_dir ?>' class="btn btn-primary <?php if($theme->isCurrentTheme()){ echo 'disabled'; } ?> " role="button">Activate</a> 
              <!--<a href="#" class="btn btn-default" role="button" data-toggle='modal' data-target='.<?=  $theme->root_dir ?>-modal-xl'>Preview</a>-->
            <!--  <a href='admin/theme/options/<?=  $theme->root_dir ?>'  class="btn btn-warning" role="button">{{ trans('actions.options') }}</a>
              <button class='btn btn-danger' data-toggle='modal' data-target='.delete_<?= $theme->root_dir ?>' <?php if($all_themes->count()==1){echo "disabled";} ?> >{{ trans('actions.delete') }}</button>
          </p>
        </div>
      </div>
    </div>-->


  <?php   Bootstrap::delete_confirmation(
      "delete_".$theme->root_dir,
      trans('actions.are_you_sure'),
      "<b>Delete this theme: </b>". $theme->getName()." <b>?</b>",
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
      <div class='modal-header modal-header-primary bg-primary'>
        <h4 class='modal-title text-white'>New file</h4>
        <button type='button' class='close text-white' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
      </div>
      <div class='modal-body'>

    <form action='admin/theme/upload' method='POST' enctype='multipart/form-data'>
    {{csrf_field()}}
    <div class='form-group'>
      <label for='file'>Upload file:</label>
      <input name='up_file[]' id='input-2' type='file' class='file' accept='.zip' multiple='true' data-show-upload='false' data-show-caption='true' required>
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
