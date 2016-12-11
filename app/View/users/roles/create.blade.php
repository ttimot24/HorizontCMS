@extends('layout')

@section('content')
<div class='container main-container'>
	<h1>Create User Group</h1><br><br>

<form action='admin/userrole/store' method='POST'>

{{csrf_field()}}

<div class='col-md-4'>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading">
      <h4><input type='text' name='group_name' style='color:black;width:100%;' required></h4> 

  </div>

  <!-- List group -->
  <ul class="list-group">

  <?php 

  $permission_list = [
                      "admin_area" => "<b style='color:red;'>Admin area</b>",
                      "blogpost" => "Blogposts",
                      "user" => "Users",
                      "page" => "Pages",
                      "media" => "Media",
                      "themes&apps" => "Themes & apps",
                      "settings" => "Settings",
                      ];

   ?> 

    @foreach($permission_list as $key => $perm_name)

        <li class='list-group-item'>{!!$perm_name!!}<input type='checkbox' class='pull-right' name='{{$key}}' value='1'></li>

    @endforeach


    <li class='list-group-item'><button type='submit' class='btn btn-warning btn-block'>Add user group</button></li>


  </ul>
</div>
</div>

</form>




</div>
@endsection