@extends('layout')

@section('content')
<div class='container main-container'>

<h2>User groups <small class='pull-right' style='margin-top:1.5%;'> All: {{$all_user_roles->count()}} </small></h2>

<br>
<div class='container col-md-10'><a href='admin/userrole/create' class='btn btn-warning' style='margin-bottom:20px;'>New user group</a></div>


<?php foreach($all_user_roles->reverse() as $role): ?>
  
<form action='admin/userrole/update/{{$role->id}}' method='POST'>

{{csrf_field()}}

<div class='col-md-3'>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading">
      <h4><?= $role->name ?><small><?php

        if(\Auth::user()->role->is($role)){
          echo Html::img(\Auth::user()->getThumb(),"class='img-rounded pull-right' style='width:15%;height:15%;'"); 
        }

      ?></small></h4> 

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

  $rights = json_decode($role->rights);

  

foreach($permission_list as $key => $perm_name){

      if(isset($rights) && in_array($key,$rights)){
        $check = "checked";
      }
      else{
        $check = "";
      }

      if($role->name =='Admin'){
        $disable = " disabled";
      }
      else{
        $disable = "";
      }

        echo "<li class='list-group-item'>".$perm_name."<input type='checkbox' class='pull-right' name='".$key."' value='1' ".$check." ".$disable."></li>";

    }

     echo "<li class='list-group-item'><button type='submit' class='btn btn-success btn-block' ".$disable.">Save changes</button></li>";

  ?>

<!--
    <li class="list-group-item">Admin area <input type='checkbox' class='pull-right' ></li>
    <li class="list-group-item">Dapibus ac facilisis in <input type='checkbox' class='pull-right'></li>
    <li class="list-group-item">Morbi leo risus <input type='checkbox' class='pull-right'></li>
    <li class="list-group-item">Porta ac consectetur ac <input type='checkbox' class='pull-right'></li>
    <li class="list-group-item">Vestibulum at eros <input type='checkbox' class='pull-right'></li>-->


  </ul>
</div>
</div>

</form>

<?php endforeach; ?>



</div>
@endsection