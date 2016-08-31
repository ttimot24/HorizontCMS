<div class='container main-container'>

<h2>User groups <small class='pull-right' style='margin-top:1.5%;'> All: <?php echo $data['counted_groups']; ?> </small></h2>

<br>
<div class='container col-md-10'><a href='admin/usergroup/create' class='btn btn-warning' style='margin-bottom:20px;'>New user group</a></div>

<!--
<a onclick=ajaxCall("POST","admin/ajax/sayhello","alert(data);"); class='btn btn-warning' style='margin-bottom:20px;'>Ajax Call Teszt</a>
-->

<!--<div class='container col-md-2' style='text-align:right;'>
  <button type='submit' href='admin/' class='btn btn-success' style='margin-bottom:20px;'>Save all changes</button>
</div>
-->

<?php foreach($data['all_group'] as $group): ?>
  
<form action='admin/usergroup/update' method='POST'>

<div class='col-md-3'>
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading">
      <h4><?= $group->name ?><small><?php

        if($user->rank == $group->id){
          echo Html::img($user->get_image(),"class='img-rounded pull-right' style='width:15%;height:15%;'"); 
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

  $rights = json_decode($group->rights);
    

    foreach($permission_list as $key => $perm_name){

      if(isset($rights->{$key}) && $rights->{$key}==1){
        $check = "checked";
      }
      else{
        $check = "";
      }

      if($group->name =='Admin'){
        $disable = " disabled";
      }
      else{
        $disable = "";
      }

        echo "<li class='list-group-item'>".$perm_name."<input type='checkbox' class='pull-right' name='".$key."' value='1' ".$check." ".$disable."></li>";

    }


    echo "<input type='hidden' name='group_id' value='".$group->id."'>";

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