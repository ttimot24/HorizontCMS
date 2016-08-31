
<div class='container main-container'>
  <h2>Edit user</h2>

<button type='button' class='btn btn-link pull-right' data-toggle='modal' data-target='.<?php echo $data['instance']->id ?>-modal-xl'>
  <img src='<?php echo $data['instance']->get_thumb() ?>' class='img img-thumbnail' width='320' >
</button>

<form role='form' action='admin/user/update/<?php echo $data['instance']->id ?>' method='POST' enctype='multipart/form-data'>

<div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>Name:</label>
       <input type='hidden' class='form-control' id='title' name='id' value='<?= $data['instance']->id ?>' >
      <input type='text' class='form-control' id='title' name='name' value='<?= htmlspecialchars($data['instance']->name,ENT_QUOTES) ?>' required>
    </div>

    <div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>Username:</label>
      <input type='text' class='form-control' id='title' name='username' value='<?= htmlspecialchars($data['instance']->username,ENT_QUOTES) ?>' required>
    </div>

<?php 
if(Session::get('id')==$data['instance']->id){
    print "<div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='title'>Password:</label>
          <input type='password' class='form-control' id='title' name='password' placeholder='new password' required>
        </div>

        <div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='title'>Password again:</label>
          <input type='password' class='form-control' id='title' name='password2' placeholder='new password again' required>
        </div>";
    }
?>

<div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>E-mail:</label>
      <input type='email' class='form-control' id='title' name='email' value='<?= htmlspecialchars($data['instance']->email,ENT_QUOTES) ?>' required>
    </div>

<div class='form-group pull-left col-xs-12 col-md-5' >
  <label for='sel1'>Select rank:</label>
  <select class='form-control' name='rank' id='sel1'>
    
<?php     

    foreach($data['ranks'] as $each){
      if($each->id == $data['instance']->rank){
         print "<option value='" .$each->id ."' selected>".htmlspecialchars($each->name,ENT_QUOTES)."</option>";
      }
      else{
        print "<option value='" .$each->id ."'>".htmlspecialchars($each->name,ENT_QUOTES)."</option>";
      }
    }

?>    

</select></div>



    <div class='form-group pull-left col-xs-12 col-md-12' >
      <label for='file'>Upload file:</label>
      <input name='up_file' id='input-2' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true'>
    </div>

    <div class='form-group pull-left col-xs-12 col-md-12' > 
    <button id='submit-btn' type='submit' class='btn btn-lg btn-primary'>Update</button>
    </div>
  </form>


<?php 

    Bootstrap::image_details($data['instance']->id,$data['instance']->get_image());

?>

</div>