@extends('layout')

@section('content')
<div class='container main-container'>


  <h2>{{trans('page.add_new_page_title')}}</h2><br><br>

  <form role='form' action='' method='POST' enctype='multipart/form-data'>
          {{ csrf_field() }}

      <div class="row">

        <section class='col-xs-12 col-md-8'>

          <div class='form-group col-xs-12 col-md-12' >
            <label for='title'>{{trans('page.menu_name')}}</label>
            <input type='text' class='form-control' id='menu-title' name='name' onkeyup="ajaxGetSlug();" placeholder='Write menu name here' required autofocus>
            <small><b>{{trans('page.semantic_url')}}:</b>&nbsp&nbsp&nbsp{{ rtrim(Config::get('app.url'),'/') }}<a class='text-primary' id='ajaxSlug'></a> </small>
          </div>

          <div class='form-group col-xs-12 col-md-12' >

            <label for='title'>{{trans('page.page_template')}}</label>

            <select class='form-control' name='url'>
              <option value='' selected>{{trans('page.default_template')}}</option>
              <?php 

                foreach($page_templates as $template){
                  echo "<option value='".$template."'>".ucfirst(rtrim(rtrim($template,".php"),".blade"))."</option>";
                }

              ?>
            </select>

          </div>

          <div class='form-group col-xs-12 col-md-6' >
            <label for='sel1'>{{trans('page.page_level')}}</label>
            <select class='form-control' name='parent_select' id='level'>  
                    <option value='0'>{{trans('page.main_menu')}}</option>
                    <option value='1'>{{trans('page.submenu')}}</option>";
            </select>
          </div>

          <div class='form-group col-xs-12 col-md-6' id='submenus'>
            <label for='submenus'>{{trans('page.parent_menu')}}</label>
            <select class='form-control' name='parent_id' >";  
                @foreach($all_page as $each)
                  <option value='{{$each->id}}'>{{$each->name}}</option> 
                @endforeach
            </select>
          </div>

          <div class='form-group pull-left col-xs-12 col-md-8 d-flex' style='margin-top:20px;margin-bottom:20px;'>
              <label style='margin-right:10px;'>{{trans('page.visibility')}}</label> 
              <div class="radio radio-primary radio-inline">
                  <input type="radio" id="inlineRadio1" value="1" name='visibility' checked>
                  <label for="inlineRadio1"> {{trans('page.visible')}} </label>
              </div>
              <div class="radio radio-inline">
                  <input type="radio" id="inlineRadio2" value="0" name='visibility'>
                  <label for="inlineRadio2"> {{trans('page.invisible')}} </label>
              </div>
          </div>

        </section>  

        <section class='col-xs-12 col-md-4'>

            <div id='select-photo' class='img-thumbnail col-xs-12 col-md-12 text-center bg-dark text-white' style='padding:20%;cursor:pointer;'>
                <span id='plus-sign' style='font-size:80px;opacity:0.6;' class="fa fa-plus-circle" 
                      aria-hidden="true" data-toggle="modal" data-target=".bs-example-modal-xl">
                </span><br>
                Add image
            </div>

            <div id='selected-image' class='pull-right img-thumbnail col-xs-12 col-md-12' style='cursor:pointer;'>
              <img id='preview-i' src='' style='width:100%;' class='img-thumbnail' data-toggle="modal" data-target=".bs-example-modal-xl">
            </div>

            <!--  <div class='form-group col-xs-12 col-md-12'>
                    <label for='file'>Upload image:</label>
                    <input name='up_file' id='input-2' onchange='readURL(this)' accept='image/*' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true'>
              </div>-->

        </section>

        <div class='form-group pull-left col-xs-12 col-md-12' >
              <label for='text'>{{trans('page.page_content')}}</label>
              <!-------------------------------------------- CK TEXT EDITOR ------------------------------------------------------>
              <textarea name='page' id='editor' rows="15" cols="80"></textarea>
                <script>
                    CKEDITOR.replace( 'editor' );
                    CKEDITOR.config.language = '<?= Config::get('app.locale') ?>';
                    CKEDITOR.config.filebrowserBrowseUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/index?path=images/pages&mode=embed') ?>';
                    CKEDITOR.config.filebrowserUploadUrl = '<?= url(Config::get('horizontcms.backend_prefix').'/file-manager/upload?module=pages') ?>';
                    CKEDITOR.config.customConfig = '<?= url(Config::get('app.url').'/resources/assets/ckeditor/config.js') ?>'; 
                </script>
              <!---------------------------------------------------- CK TEXT EDITOR -------------------------------------------------------->
        </div>

        <div class='form-group pull-left col-xs-12 col-md-8' >
            <button id='submit-btn' type='submit' class='btn btn-lg btn-primary' onclick='window.onbeforeunload = null;'>{{trans('actions.publish')}}</button>
        </div>

    </div>
  </form>
</div>


<!------------------------------------------------MODAL------------------------------------>
<div class='modal bs-example-modal-xl' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>
        <div class='modal-header'>
            <h2 class='modal-title col-md-9'>Add image</h2>
            <a id='back-button' class='btn btn-primary col-md-2'>Back</a>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button><br>
        </div>
        <div class='modal-body' style="min-height:400px;">

          <div id='upload-bar' class='form-group col-xs-12 col-md-12'>
            <label for='file'>Upload file:</label>
            <input name='up_file' id='input-2' onchange='readURL(this)' accept='image/*' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true'>
          </div>

          <div id='select-bar'>
            <?php /*foreach($data['page_images'] as $image){ 

              if(!is_dir(Storage::$path."/images/pages/".$image)){
                  echo Html::img(Storage::$path."/images/pages/".$image,"
                                                        class='img-thumbnail col-md-2' 
                                                        style='height:150px;' 
                                                        onclick=\"
                                                                    $(this).css('background-color','green'); 
                                                                    $('#select-photo').hide(); 
                                                                    $('#selected-image').attr('src','".Storage::$path."/images/pages/".$image."');
                                                                    $('#selected-image').show(); 
                                                                    \"
                                                        ");
                }
            } */?>
          </div>

              <!--     <div id='img-dashboard'>
                    <center>
                        <div id='select_select' class='img-thumbnail' style='padding:5%;cursor:pointer'>
                          <i class="fa fa-hand-o-up" style='font-size:80px;'></i><br><br>
                            Select image
                        </div>
                        <div id='upload_select' class='img-thumbnail' style='padding:5%;cursor:pointer'>
                          <i class="fa fa-cloud-upload" style='font-size:80px;'></i><br><br>
                            Upload image
                        </div>
                    </center>
                  </div>
              -->

        </div>
        <div class="modal-footer">
        </div>
    </div>
  </div>
</div>
<!------------------------------------------------MODAL-END------------------------------------>


@endsection