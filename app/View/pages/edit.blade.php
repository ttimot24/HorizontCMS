@extends('layout')

@section('content')
<div class='container main-container'>
  <h2>{{trans('page.edit_page')}}</h2>

  <form role='form' action="{{admin_link('page-update',$page->id)}}" method='POST' enctype='multipart/form-data'>
          {{ csrf_field() }}

<button type='button' class='btn btn-link pull-right' style='margin-top:-2%;' data-toggle='modal' data-target='.<?= $page->id ?>-modal-xl'>
  <img src='<?= $page->getThumb() ?>' class='img img-thumbnail' width=300  >
</button>
  <section class='col-xs-12 col-md-8'>

  <br><br>
  <input type='hidden' name='id' value='{{ $page->id }}'>
  <div class='form-group pull-left col-xs-12 col-md-12' >
      <label for='title'>{{trans('page.menu_name')}}</label>
      <input type='text' class='form-control' id='menu-title' name='name' onkeyup="ajaxGetSlug();" value='{{$page->name}}' required></input>
      <small><b>{{trans('page.semantic_url')}}:</b>&nbsp&nbsp&nbsp{{ rtrim(Config::get('app.url'),'/') }}<a class='text-muted' id='ajaxSlug'><?= UrlManager::seo_url($page->name) ?></a> </small>
    </div>

<br>
    <div class='form-group pull-left col-xs-12 col-md-12' >
         <label for='title'>{{trans('page.page_template')}}</label>

      <select class='form-control' name='url'>
        <option value=''>{{trans('page.default_template')}}</option>
        <?php 

          foreach($page_templates as $template){
            echo "<option value='".$template."' "; if($template==$page->url){ echo "selected"; } echo ">"
                    .ucfirst(rtrim(rtrim($template,".php"),".blade")).
                  "</option>";
          }

        ?>
      </select>
    </div>
<br>

<?php

echo "<div class='form-group col-xs-12 col-md-6' id='level' >
  <label for='level'>".trans('page.page_level')."</label>
  <select class='form-control' name='parent_select' >  
          <option value='0' "; if(isset($page->parent_id) && $page->parent_id==NULL){echo "selected";} echo">Main menu</option>
          <option value='1' "; if(isset($page->parent_id) && $page->parent_id!=NULL){echo "selected";} echo">Submenu</option>";
echo "</select></div>";

?>



<div class='form-group col-xs-12 col-md-6' id='submenus'>
  <label for='submenus'>Parent menu:</label>
  <select class='form-control' name='parent_id' >  

          @foreach($all_page as $each)
                <option value="{{ $each->id }}" {{ ($page->parent!=NULL && $each->is($page->parent) ? "selected":"") }}>{{ $each->name }}</option>
          @endforeach

</select></div>

<?php
/*echo "<div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='title'>Visibility:&nbsp&nbsp&nbsp&nbsp</label>
              <input type='radio' name='visibility' value='1' "; if($page->visibility==1){echo "checked";}echo">Visible&nbsp&nbsp&nbsp&nbsp&nbsp
              <input type='radio' name='visibility' value='0' "; if($page->visibility==0){echo "checked";}echo">Invisible&nbsp&nbsp&nbsp&nbsp&nbsp
      </div></br>";*/

echo "  
<div class='form-group pull-left col-xs-12 col-md-12' style='margin-top:20px;margin-bottom:20px;'>
  <label style='margin-right:10px;'>Visibility:</label> 
        <div class='radio radio-info radio-inline'>
                        <input type='radio' id='inlineRadio1' value='1' name='visibility' "; if($page->visibility==1){echo "checked";}echo">
                        <label for='inlineRadio1'> Visible </label>
                    </div>
                    <div class='radio radio-inline'>
                        <input type='radio' id='inlineRadio2' value='0' name='visibility' "; if($page->visibility==0){echo "checked";}echo">
                        <label for='inlineRadio2'> Invisible </label>
                    </div>
</div>
";

echo "</section>";
?>

<div class='form-group pull-left col-xs-12 col-md-12' >
      <label for='text'>{{trans('page.page_content')}}</label>

<!-------------------------------------------------- $ TEXT EDITOR ------------------------------------------------------>

<textarea name='page' id='editor' rows="15" cols="80">{{$page->page}}</textarea>



            <script>

                CKEDITOR.replace( 'editor' );
                CKEDITOR.config.language = '<?= Config::get('app.locale') ?>';
                CKEDITOR.config.removeButtons = 'Save,Font,FontSize,Styles,Flash';
                CKEDITOR.config.height = 400;
                CKEDITOR.config.filebrowserBrowseUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/index?path=images/pages&mode=embed') ?>';
                CKEDITOR.config.filebrowserUploadUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/upload?module=pages') ?>';

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
  </form>
</div>

<?php
Bootstrap::image_details($page->id,$page->getImage());
?>


<script type='text/javascript'>
 $(document).ready(function() {

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