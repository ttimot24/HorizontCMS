<style>
#hidden-home{
    visibility:hidden;
}

tr:hover #hidden-home{
    visibility:visible;
    color:grey;
}

tr #hidden-home a:hover{
  color:black;
}

</style>

<div class='container main-container'>


<h2>Pages <small class='pull-right' style='margin-top:1.5%;'>All: <?= count($data['all']) ?> | Visible: <?= count($data['visible']) ?> | Invisible: <?= count($data['all']) - count($data['visible']) ?></small></h2>

<br>
<div class='container'><a href='admin/page/create' class='btn btn-info' style='margin-bottom:20px;'>New page</a></div>



<table id='sort' class='table table-hover'>
    <thead>
      <tr>
      	<th>Id</th>
        <th>Image</th>
      	<th>Name</th>
        <th>Url</th>
        <th>Visibility</th>
        <th>Type</th>
        <th>Child links</th>
        <th><center>Actions</center></th>
      </tr>
    </thead><tbody>

<?php 

foreach($data['all'] as $each){

if($each->visibility==0)  {
 echo "<tr class='danger'>";
}
else if($each->parent!=0){
  echo "<tr  class='bg-info' >";
}
else{
  echo "<tr>";
}

echo  "<td>" .$each->id;

  if($data['welcome_page']->id==$each->id){
    echo " <i class='fa fa-home' style='font-size:20px;'></i>";
  }
  else{
    echo " <a href='#' data-toggle='modal' data-target='.mo-".$each->id."'><i class='fa fa-home' id='hidden-home' style='font-size:20px;'></i></a>";  
  }

  echo "
        </td>
        <td><img src='" .$each->get_thumb()."' width='70' height='50' class='img img-rounded' /></td>
        <td>" .$each->name."</td>
        <td>" .$each->url."</td>
        <td>";

        if($each->visibility==1){
          echo "<font color='green'>Visible</font>";
        }
        else{
          echo "<font color='red'>Invisible</font>";
        } 

  echo "</td>
        <td>";

        if($each->parent==0){
          echo "<b>Main</b>";
        }
        else{
          echo "Submenu <i>of</i></br><b>".$each->get_parent_page()->name."</b>";
        }

    echo "</td>";

        
    echo "<td style='padding-left:45px;'><span class='badge'>" .count($each->get_child_pages())."</span></td>";


       echo   "<td><center>";

      echo "
       <div class='btn-group' role='group'>
           <a href='admin/page/update/".$each->id."' type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>Edit</a>
           <a  type='button' data-toggle='modal' data-target='.delete_".$each->id."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
       </div>";

    /*  echo "<a href='admin/page/update/".$each->id."'>";
      echo Html::img("images/icons/edit.png","class='img img-thumbnail' width='30'");
      echo "</a>";
      echo "<button type='button' class='btn btn-link' data-toggle='modal' data-target='.delete_".$each->id."'>";
        echo Html::img("images/icons/delete.png","class='img img-thumbnail' width='30'");
        echo "</button>";*/
      
      echo "</center></td></tr>";


echo '  
<div class="modal mo-'.$each->id.'" id=" mo-'.$each->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change HomePage</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to set <b>'.$each->name.'</b> as HomePage?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="admin/page/home/'.$each->id.'" type="button" class="btn btn-primary">Set as Homepage</a>
      </div>
    </div>
  </div>
</div>';




   Bootstrap::delete_confirmation(
    "delete_".$each->id."",
    "Are you sure?",
    "<b>Delete this page: </b>".$each->name." <b>?</b>",
    "<a href='admin/page/delete/".$each->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>"
    );


        echo "</center></td></tr>";
}

?>


	</tbody>
  </table>

</div>

