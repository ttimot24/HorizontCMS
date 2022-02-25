@extends('layout')

@section('content')
<div class='container main-container'>
  <h2>{{trans('page.edit_page')}}</h2>

  <form role='form' action="{{admin_link('page-update',$page->id)}}" method='POST' enctype='multipart/form-data'>
          {{ csrf_field() }}

    <div class="row">
        <div class="col-xs-12 col-8">
            <input type='hidden' name='id' value='{{ $page->id }}'>
            <div class='form-group pull-left col-xs-12 col-md-12' >
              <label for='title'>{{trans('page.menu_name')}}</label>
              <input type='text' class='form-control' id='menu-title' name='name' onkeyup="ajaxGetSlug();" value='{{$page->name}}' required></input>
              <div class="form-text">
                <b>{{trans('page.semantic_url')}}:</b>&nbsp&nbsp&nbsp{{ rtrim(Config::get('app.url'),'/') }}<a class='text-muted' id='ajaxSlug'>{{ UrlManager::seo_url($page->name) }}</a> 
              </div>
            </div>

            <div class='form-group pull-left col-xs-12 col-md-12' >
                <label for='title'>{{trans('page.page_template')}}</label>
                <select class='form-select' name='url'>
                  <option value=''>{{trans('page.default_template')}}</option>

                    @foreach($page_templates as $template)
                      <option value='{{$template}}' @if($template==$page->url) selected @endif >
                              {{ ucfirst(rtrim(rtrim($template,".php"),".blade")) }}
                      </option>
                    @endforeach

                </select>
            </div>

            <div class="row p-3">
            <div class='form-group col-xs-12 col-md-6' id='level' >
              <label for='level'>{{trans('page.page_level')}}</label>
              <select class='form-select' name='parent_select' >  
                  <option value='0' @if(isset($page->parent_id) && $page->parent_id==NULL) selected @endif>Main menu</option>
                  <option value='1' @if(isset($page->parent_id) && $page->parent_id!=NULL) selected @endif>Submenu</option>";
              </select>
            </div>

            <div class='form-group col-xs-12 col-md-6' id='submenus'>
              <label for='submenus'>Parent menu:</label>
              <select class='form-select' name='parent_id' >  
                  @foreach($all_page as $each)
                        <option value="{{ $each->id }}" {{ ($page->parent!=NULL && $each->is($page->parent) ? "selected":"") }}>{{ $each->name }}</option>
                  @endforeach
              </select>
            </div>
            </div>

            <div class='form-group col-xs-12 col-md-12' style='margin-top:20px;margin-bottom:20px;'>
                <label class="m-2 mr-4">{{trans('page.visibility')}}</label> 
                <div class='form-check form-check-inline'>
                    <input class="form-check-input" type='radio' id='inlineRadio1' value='1' name='visibility' @if($page->visibility==1) checked @endif>
                    <label class="form-check-label" for='inlineRadio1'>  {{trans('page.visible')}} </label>
                </div>
                <div class='form-check form-check-inline'>
                    <input class="form-check-input" type='radio' id='inlineRadio2' value='0' name='visibility' @if($page->visibility==0) checked @endif>
                    <label class="form-check-label" for='inlineRadio2'> {{trans('page.invisible')}} </label>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-4">
          <button type='button' class='btn btn-link' style='margin-top:-2%;' data-bs-toggle='modal' data-bs-target='#modal-xl-<?= $page->id ?>'>
            <img src='<?= $page->getThumb() ?>' class='img img-thumbnail' width='300'  >
          </button>
        </div>

        
        <div class='form-group pull-left col-xs-12 col-md-12' >
            <label for='text'>{{trans('page.page_content')}}</label>
            <!-------------------------------------------------- $ TEXT EDITOR ------------------------------------------------------>
            <textarea name='page' id='editor' rows="15" cols="80">{{$page->page}}</textarea>
            <script>

                CKEDITOR.replace( 'editor' );
                CKEDITOR.config.language = '<?= Config::get('app.locale') ?>';
                CKEDITOR.config.filebrowserBrowseUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/index?path=images/pages&mode=embed') ?>';
                CKEDITOR.config.filebrowserUploadUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/upload?module=pages') ?>';
                CKEDITOR.config.customConfig = '<?= url(Config::get('app.url').'/resources/assets/ckeditor/config.js') ?>'; 
            </script>
            <!-------------------------------------------------------- $ TEXT EDITOR ------------------------------------------------------>
        </div>

        <div class='form-group col-xs-12 col-md-12'>
            <label for='file'>{{trans('actions.upload_image')}}:</label>
            <input name='up_file' accept='image/*' id='input-2' type='file' class='file' multiple='true' data-show-upload='true' data-show-caption='true'>
        </div>

        <div class='form-group pull-left col-xs-12 col-md-8' >
            <button id='submit-btn' type='submit' class='btn btn-primary btn-lg' >Save updates</button>
        </div>
    </div>




  </form>
</div>

<?php Bootstrap::image_details($page->id,$page->getImage()); ?>

<script type='text/javascript'>
 $(document).ready(function() {

    if($('#level').find('option:selected').val() == '1'){
     $('#submenus').show();
    }

   $('#level').change(function() {
      if($(this).find('option:selected').val() == '0') {
         $('#submenus').hide();

      }
      else{

        $('#submenus').show();
      }
   });
});
</script>


@endsection