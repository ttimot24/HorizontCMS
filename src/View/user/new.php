<div class='container main-container'>


  <h2>Add member</h2>


  <form role='form' action='admin/user/add' method='POST' enctype='multipart/form-data'>

   <div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>Name:</label>
      <input type='text' class='form-control' id='title' name='name' placeholder='Write title here' required>
    </div>


    <div class='form-group col-xs-12 col-md-4 pull-right' >
      <label for='file'>Upload image: </label>
      <input name='up_file' id='input-2' type='file' class='file' multiple='true' accept='image/*' data-show-upload='false' data-show-caption='true'>
    </div>


    <div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='username'>Username:</label>
      <input type='text' class='form-control' id='username' name='username' onblur=ajaxCall('GET','admin/ajax/checkUsername/'+document.getElementById('username').value,"if(data!=0){alert(data);document.getElementById('username').value='';}"); placeholder='Write title here' required>
    </div>

   <div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>Password:</label>
      <input type='password' class='form-control' id='password' name='password' placeholder='Write title here' required>
    </div>

   <div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>Password again:</label>
      <input type='password' class='form-control' id='password2' name='password2' placeholder='Write title here' required>
    </div>

    <div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>E-mail:</label>
      <input type='email' class='form-control' id='title' name='email' placeholder='Write title here' required>
    </div>

<div class='form-group pull-left col-xs-12 col-md-5' >
  <label for='sel1'>Select rank:</label>
  <select class='form-control' name='rank' id='sel1'>
    
<?php

   
    foreach($data['ranks'] as $each){
      print "<option value='" .$each->id ."'>".$each->name."</option>";
    }

?>    

</select></div>


<!--    <div class='form-group col-xs-12 col-md-12' >
      <label for='file'>Upload file:</label>
      <input name='up_file' id='input-2' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true'>
    </div>
-->

    <div class='form-group pull-left col-xs-12 col-md-8' >
    <button id='submit-btn' type='submit' class='btn btn-primary btn-lg'>Add member</button>
    </div>
  </form>






</div>




<script type="text/javascript">
window.onload = function () {
  document.getElementById("password").onchange = validatePassword;
  document.getElementById("password2").onchange = validatePassword;
}
function validatePassword(){
var pass2=document.getElementById("password2").value;
var pass1=document.getElementById("password").value;
if(pass1!=pass2)
  document.getElementById("password2").setCustomValidity("Passwords Don't Match");
else
  document.getElementById("password2").setCustomValidity('');  
//empty string means no validation error
}
</script>