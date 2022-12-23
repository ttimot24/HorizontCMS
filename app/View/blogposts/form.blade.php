@extends('layout')

@section('content')
<div class='container main-container'>
  <h2>{{trans(isset($page)? 'blogpost.edit_blogpost' : 'blogpost.new_blogpost')}}</h2>

  <form role='form' action="{{admin_link('blogpost-update',$blogpost->id)}}" method='POST' enctype='multipart/form-data'>

    @csrf
    @if(isset($blogpost)) @method('PUT') @endif

    <input type='hidden' name='id' value='{{ $blogpost->id }}'>

    <div class="row">

      <div class="col-xs-12 col-md-8">

          <div class='form-group pull-left col-12'>
            <label for='title'>{{trans('blogpost.title')}}:</label>
            <input type='text' class='form-control' id='title' name='title' value='{{ $blogpost->title }}' required>
          </div>

          <div class='form-group pull-left col-6'>
            <label for='sel1'>{{trans('blogpost.select_category')}}:</label>
            <select class='form-select' name='category_id' id='sel1'>

              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ ($category->is($blogpost->category)) ? "selected":"" }} >{{ $category->name }}</option>
              @endforeach

            </select>
          </div>

          <div class='form-group pull-left col-12'>
              <label for='title'>{{trans('blogpost.summary')}}:</label>
              <input type='text' class='form-control' id='title' name='summary' value='<?= htmlspecialchars($blogpost->summary,ENT_QUOTES) ?>' ></br>
          </div>

        </div>
        <div class="col-xs-12 col-md-4">
          <button type='button' class='btn btn-link pull-right' data-bs-toggle='modal' data-bs-target='#modal-xl-<?= $blogpost->id ?>'>
              <img src=<?= $blogpost->getImage(); ?> width=300 class='img img-thumbnail' >
          </button>
        </div>

        <div class="col-12">
        <div class='form-group pull-left col-12'>
              <label for='text'>{{trans('blogpost.post')}}:</label>

                <!---------------------------------------- jQUERY TEXT EDITOR ------------------------------------------------>

              <textarea name='text' id='editor' rows="15" cols="80"><?= htmlspecialchars($blogpost->text,ENT_QUOTES) ?></textarea>
              <script>
                  CKEDITOR.replace( 'editor' );
                  CKEDITOR.config.language = '<?= Config::get('app.locale') ?>';
                  CKEDITOR.config.filebrowserBrowseUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/index?path=images/blogposts&mode=embed') ?>';
                  CKEDITOR.config.filebrowserUploadUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/upload?module=blogposts') ?>';
                  CKEDITOR.config.customConfig = '<?= url(Config::get('app.url').'/resources/assets/ckeditor/config.js') ?>'; 
              </script>

                <!--<textarea name='text' class='jqte-test'><?php echo $blogpost->text ?></textarea>

                ---------------------------------------------- jQUERY TEXT EDITOR ------------------------------------------------>

          </div>

          <div class='form-group pull-left col-12'>
            <label for='file'>{{trans('actions.upload_image')}}:</label>
            <input name='up_file' accept='image/*' id='input-2' type='file' class='file' multiple='false' data-show-upload='false' data-show-caption='true'>
          </div>

          <div class='form-group pull-left col-12'>
            <button id='submit-btn' name='submit_clicked' type='submit' class='btn btn-success btn-lg' onclick='window.onbeforeunload = null;'>{{trans('actions.update')}}</button> 
            @if($blogpost->isDraft())
            <button name="active" value="1" id='submit-btn' name='submit_clicked' type='submit' class='btn btn-primary btn-lg' onclick='window.onbeforeunload = null;'>{{trans('actions.publish')}}</button> 
            @endif
            <a href="{{admin_link('blogpost-index')}}" type='button' class='btn btn-default'>{{trans('actions.cancel')}}</a>
          </div>
        </div>

         

     
  
      

      
    
    </div>

  </form>
</div>

<?php Bootstrap::image_details($blogpost->id,$blogpost->getImage()) ?>
@endsection