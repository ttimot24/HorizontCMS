@extends('layout')

@section('content')
<div class='container main-container'>
 
  <h2>{{trans('blogpost.new_blogpost')}}</h2>
 
  <form  role='form' action='' method='POST' enctype='multipart/form-data'>
 


    <br><br>

    <div class='form-group pull-left col-xs-12 col-md-8'>
      <label for='title'>{{trans('blogpost.title')}}:</label>
      <input type='text' class='form-control' id='title' name='title' required>
    </div>


    <div class='form-group col-xs-12 col-md-4 pull-right' style='max-height:100px;'>
      <center>
      <label for='file'>Upload image:</label><br>
      <input name='up_file' id='input-2' type='file' class='file' multiple='false' accept='image/*' data-show-upload='false' data-show-caption='false'>
      </center>
    </div>



   <div class='form-group pull-left col-xs-12 col-md-5' style='margin-top:2%;'>
  <label for='sel1'>Select category:</label>
  <select class='form-control' name='category' id='sel1'>



<?php  

    foreach($categories as $category){

    	echo "<option value='".$category->id."'>".$category->name."</option>";

    	
    }
?>

</select></div>

 <div class='form-group pull-left col-xs-12 col-md-8' style='margin-top:2%;'>
 <label for='title'>Summary:</label>
      <input type='text' class='form-control' id='title' name='summary' value=></br>
</div>

 <div class='form-group pull-left col-xs-12 col-md-12'>
      <label for='text'>Post:</label>
      

<!---------------------------------------- jQUERY TEXT EDITOR ------------------------------------------------>


<!--<textarea name='text' class='jqte-test'></textarea>-->

<textarea name='text' id='editor' rows="15" cols="80" style='margin-top:2%;'></textarea>


            <script>

                CKEDITOR.replace( 'editor' );
                CKEDITOR.config.language= 'en';
                CKEDITOR.config.removeButtons = 'Save';
                CKEDITOR.config.height = 350;


            </script>



<!------------------------------------------------ jQUERY TEXT EDITOR ------------------------------------------------>

  

  </div>


 <!--    <div class='form-group pull-left col-xs-12 col-md-12'>
      <label for='file'>Upload file:</label>
      <input name='up_file' id='input-2' type='file' class='file' multiple='false' data-show-upload='false' data-show-caption='true'>
    </div>
-->
<!--
     <div class='form-group col-xs-12 col-md-12'>
       <label for='title'>Publish Date: <small>Leave empty for current date</small></label>
       <input type='text' class='form-control' id='pubdate' name='pubdate' value=''>
    </div>-->


     <div class='form-group pull-left col-xs-12 col-md-12'>
    <button id='submit-btn' name='submit_clicked' type='submit' class='btn btn-primary btn-lg' onclick='window.onbeforeunload = null;'>Publish</button> 
    <a href='admin/blogpost/index' type='button' class='btn btn-default'>Cancel</a>
    </div>
  </form>
</div>
@endsection