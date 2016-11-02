@extends('layout')

@section('content')
<div class='container main-container'>
  <h2>{{trans('user.edit_user')}}</h2>

<button type='button' class='btn btn-link pull-right' data-toggle='modal' data-target='.{{ $user->id }}-modal-xl'>
  <img src='{{ $user->getThumb() }}' class='img img-thumbnail' width='320' >
</button>

{{admin_link('user-update')}}
<form role='form' action="{{admin_link('user-update',$user->id)}}" method='POST' enctype='multipart/form-data'>
        {{ csrf_field() }}

<div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>{{trans('user.create_name')}}:</label>
       <input type='hidden' class='form-control' id='title' name='id' value='{{ $user->id }}' >
      <input type='text' class='form-control' id='title' name='name' value='<?= htmlspecialchars($user->name,ENT_QUOTES) ?>' required>
    </div>

    <div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>{{trans('user.create_username')}}:</label>
      <input type='text' class='form-control' id='title' name='username' value='<?= htmlspecialchars($user->username,ENT_QUOTES) ?>' required>
    </div>


@if($user->is($current_user))
        <div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='title'>{{trans('user.create_password')}}:</label>
          <input type='password' class='form-control' id='title' name='password'  required>
        </div>

        <div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='title'>{{trans('user.create_password_again')}}:</label>
          <input type='password' class='form-control' id='title' name='password2'  required>
        </div>
@endif

<div class='form-group pull-left col-xs-12 col-md-8' >
      <label for='title'>{{trans('user.create_email')}}:</label>
      <input type='email' class='form-control' id='title' name='email' value='<?= htmlspecialchars($user->email,ENT_QUOTES) ?>' required>
    </div>

<div class='form-group pull-left col-xs-12 col-md-5' >
  <label for='sel1'>{{trans('user.create_select_rank')}}:</label>
  <select class='form-control' name='role_id' id='sel1'>
    
<?php     

    foreach($user_roles as $each){
      if($each->is($user->role)){
         echo "<option value='" .$each->id ."' selected>".htmlspecialchars($each->name,ENT_QUOTES)."</option>";
      }
      else{
        echo "<option value='" .$each->id ."'>".htmlspecialchars($each->name,ENT_QUOTES)."</option>";
      }
    }

?>    

</select></div>



    <div class='form-group pull-left col-xs-12 col-md-12' >
      <label for='file'>{{trans('actions.upload_image')}}:</label>
      <input name='up_file' id='input-2' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true'>
    </div>

    <div class='form-group pull-left col-xs-12 col-md-12' > 
    <button id='submit-btn' type='submit' class='btn btn-lg btn-primary'>{{trans('actions.update')}}</button>
    </div>
  </form>


<?php 

    Bootstrap::image_details($user->id,$user->getImage());

?>

<script type="text/javascript">
window.onload = function () {
  document.getElementById("password").onchange = validatePassword;
  document.getElementById("password2").onchange = validatePassword;
}
function validatePassword(){
var pass2=document.getElementById("password2").value;
var pass1=document.getElementById("password").value;
if(pass1!=pass2)
  document.getElementById("password2").setCustomValidity("{{trans('user.pws_not_equal')}");
else
  document.getElementById("password2").setCustomValidity('');  
//empty string means no validation error
}
</script>


</div>
@endsection