<div class='container main-container'>
  <h2>Edit post</h2>
  <form role='form' action='admin/blogpost/update/<?php echo $data['instance']->id ?>' method='POST' enctype='multipart/form-data'>
     <div class='form-group pull-left col-xs-12 col-md-8'>
    <input type='hidden' name='id' value=<?php echo $data['instance']->id ?>>
      <label for='title'>Title:</label>
      <input type='text' class='form-control' id='title' name='title' value='<?= htmlspecialchars($data['instance']->title,ENT_QUOTES) ?>' required>
    </div>

<button type='button' class='btn btn-link pull-right' data-toggle='modal' data-target='.<?= $data['instance']->id ?>-modal-xl'>
    <img src=<?php echo $data['instance']->get_image(); ?> width=300 class='img img-thumbnail' >
</button>


   <div class='form-group pull-left col-xs-12 col-md-5'>
  <label for='sel1'>Select category:</label>
  <select class='form-control' name='category' id='sel1'>



<?php  

    foreach($data['categories'] as $category){
    	if($data['instance']->category == $category->id){
    		print "<option value='".$category->id."' selected>".$category->name."</option>";
    	}else{
    		print "<option value='".$category->id."'>".$category->name."</option>";
    	}
    	
    }
?>

</select></div>

 <div class='form-group pull-left col-xs-12 col-md-8'>
 <label for='title'>Summary:</label>
      <input type='text' class='form-control' id='title' name='summary' value='<?= htmlspecialchars($data['instance']->summary,ENT_QUOTES) ?>' ></br>
</div>

 <div class='form-group pull-left col-xs-12 col-md-12'>
      <label for='text'>Post:</label>
      

<!---------------------------------------- jQUERY TEXT EDITOR ------------------------------------------------>

<textarea name='text' id='editor' rows="15" cols="80"><?= htmlspecialchars($data['instance']->text,ENT_QUOTES) ?></textarea>


            <script>

                CKEDITOR.replace( 'editor' );
                CKEDITOR.config.language= 'en';
                CKEDITOR.config.removeButtons = 'Save';
                CKEDITOR.config.height = 350;


            </script>


<!--<textarea name='text' class='jqte-test'><?php echo $data['instance']->text ?></textarea>

---------------------------------------------- jQUERY TEXT EDITOR ------------------------------------------------>

  

  </div>


     <div class='form-group pull-left col-xs-12 col-md-12'>
      <label for='file'>Upload file:</label>
      <input name='up_file' id='input-2' type='file' class='file' multiple='false' data-show-upload='false' data-show-caption='true'>
    </div>

     <div class='form-group pull-left col-xs-12 col-md-12'>
    <button id='submit-btn' name='submit_clicked' type='submit' class='btn btn-success btn-lg' onclick='window.onbeforeunload = null;'>Update</button> 
    <a href='admin/blogpost/index' type='button' class='btn btn-default'>Cancel</a>
    </div>
  </form>
</div>

<?php Bootstrap::image_details($data['instance']->id,$data['instance']->get_image()) ?>