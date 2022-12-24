@extends('layout')

@section('content')
<div class='container main-container'>
  <h2>{{trans(isset($blogpost)? 'blogpost.edit_blogpost' : 'blogpost.new_blogpost')}}</h2>

  <form role='form' action="{{isset($blogpost)? admin_link('blogpost-update', $blogpost->id) : admin_link('blogpost-store')}}" method='POST' enctype='multipart/form-data'>

    @csrf
    @if(isset($blogpost)) @method('PUT') @endif

    <div class="row">

      <div class="col-xs-12 col-md-8">

          <div class='form-group pull-left col-12'>
            <label for='title'>{{trans('blogpost.title')}}:</label>
            <input type='text' class='form-control' id='title' name='title' value="{{ old('title', isset($blogpost)? $blogpost->title : '') }}" required>
          </div>

          <div class='form-group pull-left col-6'>
            <label for='sel1'>{{trans('blogpost.select_category')}}:</label>
            <select class='form-select' name='category_id' id='sel1'>

              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ ( isset($blogpost) && $category->is($blogpost->category)) ? "selected":"" }} >{{ $category->name }}</option>
              @endforeach

            </select>
          </div>

          <div class='form-group pull-left col-12'>
              <label for='title'>{{trans('blogpost.summary')}}:</label>
              <input type='text' class='form-control' id='title' name='summary' value="{{ old('summary', isset($blogpost)? $blogpost->summary : '') }}" ></br>
          </div>

        </div>
        <div class="col-md-4 col-sm-12">

          @if(isset($blogpost))
            <button type='button' class='btn btn-link mb-5 w-100' data-bs-toggle='modal' data-bs-target='#modal-xl-{{ $blogpost->id }}'>
              <img src='{{ $blogpost->getThumb() }}' class='img img-thumbnail w-100' >
            </button>
          @endif

          <div class='form-group' >
            <label for='file'>{{trans('actions.upload_image')}}:</label>
            <input name='up_file' accept='image/*' id='input-2' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true'>
          </div>

        </div>

        <div class="col-12">
        <div class='form-group pull-left col-12'>
              <label for='text'>{{trans('blogpost.post')}}:</label>

                <!---------------------------------------- jQUERY TEXT EDITOR ------------------------------------------------>

              <textarea name='text' id='editor' rows="15" cols="80">
                {{ old('blogpost', isset($blogpost)? $blogpost->text: '') }}
              </textarea>
              <script>
                  CKEDITOR.replace( 'editor' );
                  CKEDITOR.config.language = '<?= Config::get('app.locale') ?>';
                  CKEDITOR.config.filebrowserBrowseUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/index?path=images/blogposts&mode=embed') ?>';
                  CKEDITOR.config.filebrowserUploadUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/upload?module=blogposts') ?>';
                  CKEDITOR.config.customConfig = '<?= url(Config::get('app.url').'/resources/assets/ckeditor/config.js') ?>'; 
              </script>

                <!----------------------------------------- jQUERY TEXT EDITOR ------------------------------------------------>

          </div>

          <div class='form-group col-12'>
          
            @if(!isset($blogpost))
              <button name="active" value="1" id='submit-btn' type='submit' class='btn btn-primary btn-lg' onclick='window.onbeforeunload = null;'>{{trans('actions.publish')}}</button>
              <button name="active" value="0" id='submit-btn' type='submit' class='btn btn-info' onclick='window.onbeforeunload = null;'>{{trans('actions.save_draft')}}</button> 
            @else
              <button id='submit-btn' name='active' value="<?= isset($blogpost) && $blogpost->isDraft()? 0 : 1 ?>" type='submit' class='btn btn-success btn-lg' onclick='window.onbeforeunload = null;'>{{trans('actions.update')}}</button> 
              @if($blogpost->isDraft())
                <button name="active" value="1" id='submit-btn' name='submit_clicked' type='submit' class='btn btn-primary btn-lg' onclick='window.onbeforeunload = null;'>{{trans('actions.publish')}}</button> 
              @endif
            @endif
            <a href="{{admin_link('blogpost-index')}}" type='button' class='btn btn-default'>{{trans('actions.cancel')}}</a>
          </div>
        </div>     
    
    </div>

  </form>
</div>

<?php 
  if(isset($blogpost)){
    Bootstrap::image_details($blogpost->id,$blogpost->getImage()) ;
  }
?>
@endsection