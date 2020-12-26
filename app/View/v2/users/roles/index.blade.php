@extends('layout')

@section('content')
<div class='container main-container'>

<h2>User groups <small class='pull-right' style='margin-top:1.5%;'> All: {{$all_user_roles->count()}} </small></h2>

<br>
<div ><a href="{{admin_link('user_role-create')}}" class='btn btn-warning' style='margin-bottom:20px;'>New user group</a></div>

<div class="row">
<?php foreach($all_user_roles->reverse() as $role): ?>
  <div class='col-md-3'>
<form action="{{admin_link('user_role-update',$role->id)}}" method='POST'>

{{csrf_field()}}


  <div class="panel panel-primary mb-4">
    <!-- Default panel contents -->
    <div class="panel-heading bg-primary p-3">
        <h4 class="text-white">
          <?= $role->name ?>
          <small>
            <?php
              if(\Auth::user()->role->is($role)){
                echo Html::img(\Auth::user()->getThumb(),"class='img-rounded pull-right' style='width:15%;height:15%;'"); 
              }
            ?>
          </small>
        </h4> 

    </div>

    <!-- List group -->
    <ul class="list-group">

    <?php 
    

    foreach($permission_list as $key => $perm_name){

        if(isset($role->rights) && in_array($key,$role->rights)){
          $check = "checked";
        }
        else{
          $check = "";
        }


        $disable = $role->name =='Admin'? " disabled" : "";


          $perm_name = str_replace("Admin area","<b style='color:red;'>Admin area</b>",$perm_name);

          echo "<li class='list-group-item bg-dark text-white'>".$perm_name."<input type='checkbox' class='pull-right' name='".$key."' value='1' ".$check." ".$disable."></li>";

      }

      echo "<li class='list-group-item bg-dark text-white'>

          <div class='btn-group' role='group' style='width:100%;'>

              <button type='submit' class='btn btn-success btn-sm' ".$disable." style='width:80%;'>Save changes</button>
            
              <a data-toggle='modal' data-target='.delete_".$role->id."' class='btn btn-danger btn-sm pull-right' ".$disable."><i class='fa fa-trash-o' aria-hidden='true'></i></a>

        </div>

        </li>";

  

      Bootstrap::delete_confirmation(
          "delete_".$role->id."",
          trans('actions.are_you_sure'),
          "<div style='color:black;'><b>".trans('actions.delete_this',['content_type' => 'role']).": </b>".$role->name." <b>?</b></div>",
          "<a href='".admin_link('user_role-delete',$role->id)."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
          <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
          );

  ?>

    </ul>
  </div>


</form>
</div>
<?php endforeach; ?>

</div>

</div>
@endsection