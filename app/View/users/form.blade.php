@extends('layout')

@section('content')
<div class='container main-container'>


  <h2>{{trans(isset($user)? 'user.edit_user' : 'user.create_user')}}</h2>


  <form role='form' action="{{ isset($user)? admin_link('user-update', $user->id) : admin_link('user-store')}}" method='POST' enctype='multipart/form-data'>
    @csrf
    
    @if(isset($user)) @method('PUT') @endif

    <div class="row">
        <div class='form-group pull-left col-xs-12 col-md-8' >
          <div class='form-group'>
            <label for='name'>{{trans('user.create_name')}}:</label>
            <input type='text' class='form-control' id='name' name='name' value="{{ old('name', isset($user)? $user->name : '') }}" required autofocus>
          </div>

          <div class='form-group'>
            <label for='username'>{{trans('user.create_username')}}:</label>
            <input type='text' class='form-control' id='username' name='username' value="{{ old('username', isset($user)? $user->username : '') }}"  placeholder='Write username here' required>
          </div>

        @if(!isset($user) || ($user && $user->is($current_user)))  
          <div class='form-group'>
              <label for='title'>{{trans('user.create_password')}}:</label>
              <input type='password' class='form-control' id='password' name='password'  required>
          </div>


          <div class='form-group'>
              <label for='title'>{{trans('user.create_password_again')}}:</label>
              <input type='password' class='form-control' id='password2' name='password2' required>
          </div>
        @endif


        <div class='form-group'>
          <label for='title'>{{trans('user.create_email')}}:</label>
          <input type='email' class='form-control' id='title' name='email' value="{{ old('email', isset($user)? $user->email : '') }}" required>
        </div>

        <div class='form-group'>
          <label for='title'>{{trans('user.create_phone')}}:</label>
          <input type='text' class='form-control' id='phone' name='phone' value="{{ old('phone', isset($user)? $user->phone : '') }}" required>
        </div>



        <div class='form-group col-6' >
          <label for='sel1'>{{trans('user.create_select_rank')}}:</label>
          <select class='form-select' name='role_id' id='sel1'>
            
          
              @foreach($role_options as $each)
                @if($each->permission<=$current_user->role->permission)
                  <option value="{{$each->id}}" 
                  @if(isset($user))
                    {{ ($each->is($user->role) ? "selected":"") }}
                  @elseif(isset($settings['default_user_role']))
                    @if($each->id==$settings['default_user_role']) selected @endif
                  @endif
                  >
                  {{ $each->name }}
                  </option>
                @endif
              @endforeach   

          </select>
        </div>
      </div>

      <div class="col-md-4 col-sm-12">

        @if(isset($user))
          <button type='button' class='btn btn-link mb-5 w-100' data-bs-toggle='modal' data-bs-target='#modal-xl-{{ $user->id }}'>
            <img src='{{ $user->getThumb() }}' class='img img-thumbnail' width='320' >
          </button>
        @endif

        <div class='form-group' >
          <label for='file'>{{trans('actions.upload_image')}}:</label>
          <input name='up_file' accept='image/*' id='input-2' type='file' class='file' multiple='true' data-show-upload='false' data-show-caption='true'>
        </div>
      </div>

      </div>

        <div class='form-group pull-left col-xs-12 col-md-8' >
            <button id='submit-btn' type='submit' class='btn btn-primary btn-lg'>{{trans(isset($user)? 'actions.update' : 'user.create_add_user_button')}}</button>
        </div>

  </form>

</div>


<?php 
    if(isset($user)){
      Bootstrap::image_details($user->id,$user->getImage());
    }
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
  document.getElementById("password2").setCustomValidity("<?= trans('user.pws_not_equal') ?>");
else
  document.getElementById("password2").setCustomValidity('');  
//empty string means no validation error
}
</script>

@endsection