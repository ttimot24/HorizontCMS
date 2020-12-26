@extends('layout')

@section('content')
<div class='container main-container'>


  <h2>{{trans('user.create_user')}}</h2>


  <form role='form' action="{{admin_link('user-create')}}" method='POST' enctype='multipart/form-data'>
    {{ csrf_field() }}

    <div class="row">
      <div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='title'>{{trans('user.create_name')}}:</label>
          <input type='text' class='form-control' id='title' name='name' required autofocus>
        </div>


        <div class='form-group col-xs-12 col-md-4 pull-right' >
          <label for='file'>{{trans('actions.upload_image')}}: </label>
          <input name='up_file' id='input-2' type='file' class='file' multiple='true' accept='image/*' data-show-upload='false' data-show-caption='true'>
        </div>


        <div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='username'>{{trans('user.create_username')}}:</label>
          <input type='text' class='form-control' id='username' name='username' placeholder='Write username here' required>
        </div>

      <div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='title'>{{trans('user.create_password')}}:</label>
          <input type='password' class='form-control' id='password' name='password'  required>
        </div>


      <div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='title'>{{trans('user.create_password_again')}}:</label>
          <input type='password' class='form-control' id='password2' name='password2' required>
        </div>

        <div class='form-group pull-left col-xs-12 col-md-4' >
        </div>

        <div class='form-group pull-left col-xs-12 col-md-8' >
          <label for='title'>{{trans('user.create_email')}}:</label>
          <input type='email' class='form-control' id='title' name='email' required>
        </div>



        <div class='form-group pull-left col-xs-12 col-md-5' >
          <label for='sel1'>{{trans('user.create_select_rank')}}:</label>
          <select class='form-control' name='role_id' id='sel1'>
            
          
              @foreach($roles as $each)
                @if($each->permission<=$current_user->role->permission)
                  <option value='{{$each->id}}' @if(isset($settings['default_user_role']) && $each->id==$settings['default_user_role']) selected @endif >{{$each->name}}</option>
                @endif
              @endforeach   

          </select>
        </div>


        <div class='form-group pull-left col-xs-12 col-md-8' >
            <button id='submit-btn' type='submit' class='btn btn-primary btn-lg'>{{trans('user.create_add_user_button')}}</button>
        </div>
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
  document.getElementById("password2").setCustomValidity("<?= trans('user.pws_not_equal') ?>");
else
  document.getElementById("password2").setCustomValidity('');  
//empty string means no validation error
}
</script>

@endsection