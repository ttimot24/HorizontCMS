extends('layout')

@section('content')
<div class='container main-container'>


  <h2>Add new page</h2><br><br>

  <form role='form' action='' method='POST' enctype='multipart/form-data'>
          {{ csrf_field() }}

  <section class='col-xs-12 col-md-8'>

    <div class='form-group col-xs-12 col-md-12' >
      <label for='title'>Menu:</label>
      <input type='text' class='form-control' id='menu-title' name='name' onkeyup="ajaxGetSlug();" placeholder='Write menu name here' required>
      <small><b>Semantic url:</b>&nbsp&nbsp&nbsp<?= $data['domain'].rtrim(BASE_DIR,'/') ?><a class='text-primary' id='ajaxSlug'></a> </small>
    </div>
<br><br>
    <div class='form-group col-xs-12 col-md-12' >

      <label for='title'>Page template:</label>

      <select class='form-control' name='url'>
        <option value='' selected>Default</option>
        <?php 

          foreach($page_templates as $template){
            echo "<option value='".$template."'>".ucfirst(rtrim($template,".php"))."</option>";
          }

        ?>
      </select>

    </div>

<br><br>

<div class='form-group col-xs-12 col-md-6' >
  <label for='sel1'>Level:</label>
  <select class='form-control' name='parent_select' id='level'>  
          <option value='1'>Main menu</option>
          <option value='0'>Submenu</option>";
</select></div>


<div class='form-group pull-left col-xs-12 col-md-6' id='submenus'>
  <label for='submenus'>Parent menu:</label>
  <select class='form-control' name='parent' >";  
      
<?php     
      echo "<option value='0'>None</option>"; 

      foreach($all_page as $each){
         echo "<option value='".$each->id."'>".$each->name."</option>"; 
      }

?>

</select></div>


<div class='form-group pull-left col-xs-12 col-md-8' style='margin-top:20px;margin-bottom:20px;'>
  <label style='margin-right:10px;'>Visibility:</label> 
        <div class="radio radio-primary radio-inline">
                        <input type="radio" id="inlineRadio1" value="1" name='visibility' checked>
                        <label for="inlineRadio1"> Visible </label>
                    </div>
                    <div class="radio radio-inline">
                        <input type="radio" id="inlineRadio2" value="0" name='visibility'>
                        <label for="inlineRadio2"> Invisible </label>
                    </div>
</div>

</section>  

<section class='col-xs-12 col-md-4' >
<br>
<div id='select-photo' class='img-thumbnail col-xs-12 col-md-12' style='padding:20%;cursor:pointer;height:100%;'>
<center>
    <span id='plus-sign' style='font-size:80px;opacity:0.6;' class="glyphicon glyphicon-plus-sign" 
          aria-hidden="true" data-toggle="modal" data-target=".bs-example-modal-xl">
    </span>
    
<br>
Add image
</center>
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
      <label for='text'>Page content:</label>



<!-------------------------------------------- CK TEXT EDITOR ------------------------------------------------------>

<textarea name='page' id='editor' rows="15" cols="80"></textarea>


            <script>

                CKEDITOR.replace( 'editor' );
                CKEDITOR.config.language = '<?= Config::get('app.locale') ?>';
                CKEDITOR.config.removeButtons = 'Save';
                CKEDITOR.config.height = 350;

            </script>

<!---------------------------------------------------- CK TEXT EDITOR -------------------------------------------------------->

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
          	<?php foreach($data['page_images'] as $image){ 

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
          	} ?>
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










    <div class='form-group pull-left col-xs-12 col-md-8' >
    <button id='submit-btn' type='submit' class='btn btn-lg btn-primary' onclick='window.onbeforeunload = null;'>{{trans('actions.publish')}}</button>
    </div>
  </form>
</div>
@endsection