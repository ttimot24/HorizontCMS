@extends('layout')

@section('content')
<div class='container main-container'>
 
  <h2>{{trans('blogpost.new_blogpost')}}</h2>
 
  <form  role='form' action='' method='POST' enctype='multipart/form-data'>
    {{ csrf_field() }}
    <br><br>

    <div class="row">

  
    <div class='form-group float-left col-xs-12 col-md-8'>
      <label for='title'>{{trans('blogpost.title')}}:</label>
      <input type='text' class='form-control' id='title' name='title' required autofocus>
    </div>


    <div class='form-group col-xs-12 col-md-4 float-right' style='max-height:100px;'>
      <center>
      <label for='file'>{{trans('actions.upload_image')}}:</label><br>
      <input name='up_file' id='input-2' type='file' class='file' multiple='false' accept='image/*' data-show-upload='false' data-show-caption='false'>
      </center>
    </div>



    <div class='form-group float-left col-xs-12 col-md-5' style='margin-top:2%;'>
      <label for='sel1'>{{trans('blogpost.select_category')}}:</label>
      <select class='form-control' name='category_id' id='sel1'>

          @foreach($categories as $category)
            <option value='{{$category->id}}'>{{$category->name}}</option>
          @endforeach

      </select>
    </div>


    <div class='form-group col-xs-12 col-md-8' style='margin-top:2%;'>
        <label for='title'>{{trans('blogpost.summary')}}:</label>
        <input type='text' class='form-control' id='title' name='summary' value=></br>
    </div>

    <div class='form-group col-xs-12 col-md-12'>
        <label for='text'>{{trans('blogpost.post')}}:</label>  

          <!---------------------------------------- jQUERY TEXT EDITOR ------------------------------------------------>

        <textarea name='text' id='editor' rows="15" cols="80" style='margin-top:2%;'></textarea>
                <script>
                    CKEDITOR.replace( 'editor' );
                    CKEDITOR.config.language = '<?= Config::get('app.locale') ?>';
                    CKEDITOR.config.filebrowserBrowseUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/index?path=images/blogposts&mode=embed') ?>';
                    CKEDITOR.config.filebrowserUploadUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/upload?module=blogposts') ?>';
                    CKEDITOR.config.customConfig = '<?= url(Config::get('app.url').'/resources/assets/ckeditor/config.js') ?>';   
                </script>
          <!------------------------------------------------ jQUERY TEXT EDITOR ------------------------------------------------>

      </div>


 <!--    <div class='form-group float-left col-xs-12 col-md-12'>
      <label for='file'>Upload file:</label>
      <input name='up_file' id='input-2' type='file' class='file' multiple='false' data-show-upload='false' data-show-caption='true'>
    </div>
-->
<!--
     <div class='form-group col-xs-12 col-md-12'>
       <label for='title'>Publish Date: <small>Leave empty for current date</small></label>
       <input type='text' class='form-control' id='pubdate' name='pubdate' value=''>
    </div>-->


      <div class='form-group float-left col-xs-12 col-md-12'>
        <button name="active" value="1" id='submit-btn' type='submit' class='btn btn-primary btn-lg' onclick='window.onbeforeunload = null;'>{{trans('actions.publish')}}</button>
        <button name="active" value="0" id='submit-btn' type='submit' class='btn btn-info' onclick='window.onbeforeunload = null;'>{{trans('actions.save_draft')}}</button> 
        <a href="{{admin_link('blogpost-index')}}" type='button' class='btn btn-default'>{{trans('actions.cancel')}}</a>
      </div>
      </div>

  </form>
</div> 
@endsection