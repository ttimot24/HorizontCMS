<div class='container main-container'>

<h2>Registered users <small class='pull-right' style='margin-top:1.5%;'>All: <?= $data['number']; ?>  | Active: <?= $data['active']; ?> | Inactive: <?php echo $data['number']-$data['active']; ?></small></h2>

<br>
<div class='container col-md-12'><a href='admin/user/add' class='btn btn-warning' style='margin-bottom:20px;'>New user</a></div>

<table class='table table-hover'>
    <thead>
      <tr>
      	<th>Id</th>
      	<th>Profile</th>
        <th>Name</th>
        <th>Username</th>
        <th>E-mail</th>
        <th>Rank</th>
        <th>Session</th>
        <th><center>Action</center></th>
      </tr>
    </thead><tbody>

<?php 
isset($_GET['limit']) ?: $_GET['limit'] = 0;

if(isset($_GET['limit'])){
  $start = $_GET['limit']*100;
}
foreach(array_slice($data['users'],$start,100) as $each){

if($each->active==0)  {
 echo "<tr class='danger'>";
}
else{
  echo "<tr>";
}



echo "<td>". $each->id ."</td>";
echo "<td>";
echo Html::img($each->get_image(),"class='img-rounded' style='object-fit:cover;' width='50' height='50'");
echo	"</td>";

echo "<td><a href='admin/user/view/".$each->id."'>".$each->name."</a></td>";
echo "<td>".$each->username."</td>";
echo "<td>".$each->email."</td>";

        echo "<td>";
        if($each->rank<4){
          echo  "<span class='label label-default' style='font-size:13px; display:block;'>".$each->get_rank()->name ."</span>";
        }else{
          echo "<span class='label label-danger' style='font-size:13px; display:block;'>".$each->get_rank()->name."</span>";
        }
        echo "</td>"; 





        if($each->session==1){
          echo "<td><font color='green'>&nbsp&nbsp&nbspOnline</font></td>";	
        }
        else{
          echo "<td><font color='red'>&nbsp&nbsp&nbspOffline</font></td>";	
        }


echo   "<td><center>";

echo "
       <div class='btn-group' role='group'>
           <a href='admin/user/update/".$each->id."' type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>Edit</a>
           <a  type='button' data-toggle='modal' data-target='.delete_".$each->id."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
       </div>";
/*
      echo "<a href='admin/user/update/".$each->id."'>";
      echo Html::img("images/icons/edit.png","class='img img-thumbnail' width='30'");
      echo "</a>";
      echo "<button type='button' class='btn btn-link' data-toggle='modal' data-target='.delete_".$each->id."'>";
        echo Html::img("images/icons/delete.png","class='img img-thumbnail' width='30'");
        echo "</button>";*/
      
      echo "</center></td></tr>";




   Bootstrap::delete_confirmation(
    "delete_".$each->id."",
    "Are you sure?",
    "<b>Delete this user: </b>".$each->username." <b>?</b>",
    "<a href='admin/user/delete/".$each->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>"
    );




}





echo "</tbody>
  </table>";
?>


<?php if($data['show_pagination']!=FALSE): ?>
<hr/><b>Page:&nbsp&nbsp</b>
<div class='page_list' style='clear:both;'>
<ul class='pagination'>
<?php 
          for($i=1;$i<=$data['pages_number'];$i++){

            if($data['page']==$i){
              echo "<li class='active'><a href='admin/user/page/".$i."'>" .$i."</a></li>&nbsp&nbsp";
            }else{
              echo "<li><a href='admin/user/page/".$i."'>" .$i ."</a></li>&nbsp&nbsp";
            }

          }

?>

</ul></div>
<?php endif; ?>

</div>