@extends('layout')

@section('content')
<div class='container main-container'>

<h2>{{trans('user.registered_users')}} <small class='pull-right' style='margin-top:1.5%;'>{{trans('user.all')}}: {{$number_of_users}}  | {{trans('user.active')}}: {{$active_users}} | {{trans('user.inactive')}}: {{$number_of_users-$active_users}}</small></h2>

<br>
<div class='container col-md-12'><a href='user/add' class='btn btn-warning' style='margin-bottom:20px;'>{{trans('user.new_user_button')}}</a></div>

<table class='table table-hover'>
    <thead>
      <tr>
      	<th>{{trans('user.th_id')}}</th>
      	<th>{{trans('user.th_image')}}</th>
        <th>{{trans('user.th_name')}}</th>
        <th>{{trans('user.th_username')}}</th>
        <th>{{trans('user.th_email')}}</th>
        <th>{{trans('user.th_rank')}}</th>
        <th>{{trans('user.th_session')}}</th>
        <th><center>{{trans('action.th_action')}}</center></th>
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
echo Html::img($each->getImage(),"class='img-rounded' style='object-fit:cover;' width='50' height='50'");
echo	"</td>";

echo "<td><a href='user/view/".$each->id."'>".$each->name."</a></td>";
echo "<td>".$each->username."</td>";
echo "<td>".$each->email."</td>";

        echo "<td>";
        if($each->rank<4){
          echo  "<span class='label label-default' style='font-size:13px; display:block;'>".$each->get_rank()->name ."</span>";
        }else{
          echo "<span class='label label-danger' style='font-size:13px; display:block;'>".$each->get_rank()->name."</span>";
        }
        echo "</td><td style='text-align:center;'><b>"; 





        if($each->session==1){
          echo "<font color='green'>Online</font>";	
        }
        else{
          echo "<font color='red'>Offline</font>";	
        }


echo   "</b></td><td><center>";

$disabled = "";

echo "
       <div class='btn-group' role='group'>
           <a href='user/update/".$each->id."' type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>Edit</a>";
      if($each->id==1){
        $disabled='disabled';
      }           
           echo "<a type='button' data-toggle='modal' data-target='.delete_".$each->id."' class='btn btn-danger btn-sm' ".$disabled."><i class='fa fa-trash-o' aria-hidden='true'></i></a>";

echo "</div>";

      
      echo "</center></td></tr>";



  if($each->id!=1){
  /* Bootstrap::delete_confirmation(
    "delete_".$each->id."",
    "Are you sure?",
    "<b>Delete this user: </b>".$each->username." <b>?</b>",
    "<a href='user/delete/".$each->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>"
    );*/
 }


}





echo "</tbody>
  </table>";
?>


    <center>
        {{$all_users->links()}}
    </center>

</div>
@endsection