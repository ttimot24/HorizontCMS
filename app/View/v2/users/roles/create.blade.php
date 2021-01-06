@extends('layout')

@section('content')
<div class='container main-container'>
	<h2>Create User Group</h2><br><br>

<form action="{{admin_link('user_role-store')}}" method='POST'>

{{csrf_field()}}

<div class='col-md-4'>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading bg-primary p-3">
      <input type='text' class='form-control' name='group_name' required>
  </div>

  <!-- List group -->
  <ul class="list-group">


    @foreach($permission_list as $key => $perm_name)

        <?php $perm_name = str_replace("Admin area","<b style='color:red;'>Admin area</b>",$perm_name) ?>

        <li class='list-group-item bg-dark text-white'>{!!$perm_name!!}<input type='checkbox' class='pull-right' name='{{$key}}' value='1'></li>

    @endforeach


    <li class='list-group-item bg-dark'><button type='submit' class='btn btn-warning btn-block'>Add user group</button></li>


  </ul>
</div>
</div>

</form>




</div>
@endsection