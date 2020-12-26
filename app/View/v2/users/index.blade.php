@extends('layout')

@section('content')
<div class='container main-container'>

<h2>{{trans('user.registered_users')}} <small class='pull-right' style='margin-top:1.5%;'>{{trans('user.all')}}: {{$number_of_users}} | {{trans('user.active')}}: {{$active_users}} | {{trans('user.inactive')}}: {{$number_of_users-$active_users}}</small></h2>


<div class='container col-md-12'><a href="{{admin_link('user-create')}}" class='btn btn-warning' style='margin-bottom:20px;'>{{trans('user.new_user_button')}}</a></div>

<table class='table table-hover'>
    <thead>
      <tr class="bg-dark text-white">
      	<th>{{trans('user.th_id')}}</th>
      	<th>{{trans('user.th_image')}}</th>
        <th>{{trans('user.th_name')}}</th>
        <th>{{trans('user.th_username')}}</th>
        <th>{{trans('user.th_email')}}</th>
        <th>{{trans('user.th_rank')}}</th>
        <th>{{trans('user.th_session')}}</th>
        <th><center>{{trans('actions.th_action')}}</center></th>
      </tr>
    </thead><tbody>

<?php 

foreach($all_users as $each){

echo $each->active==0? "<tr class='danger'>" : "<tr>" ;

echo "<td>". $each->id ."</td>";
echo "<td>";
echo Html::img($each->getImage(),"class='img-rounded' style='object-fit:cover;' width='50' height='50'");
echo	"</td>";

echo "<td><a href='".admin_link('user-view',$each->id)."'>".$each->name."</a></td>";
echo "<td>".$each->username."</td>";
echo "<td>".$each->email."</td>";

        echo "<td> 
                <span class='badge ".( ($each->isAdmin())? "badge-danger" : "badge-dark" ) ."' style='font-size:13px; display:block;'>".$each->role->name ."</span>
             </td>";
        echo "<td style='text-align:center;'><b>"; 





        if($each->isOnline()){
          echo "<font color='green'>Online</font>";	
        }
        else{
          echo "<font color='red'>Offline</font>";	
        }


echo   "</b></td><td><center>";

$disabled = "";
      if($each->role_id>=\Auth::user()->role_id || $each->is(Auth::user())){
        $disabled='disabled';
      }   

echo "
       <div class='btn-group' role='group'>
           <a href='".admin_link('user-edit',$each->id)."' type='button' class='btn btn-warning btn-sm' style='min-width:70px;' ".$disabled.">".trans('actions.edit')."</a>";
         
           echo "<a type='button' data-toggle='modal' data-target='.delete_".$each->id."' class='btn btn-danger btn-sm' ".$disabled."><i class='fa fa-trash-o' aria-hidden='true'></i></a>";

echo "</div>";

      
      echo "</center></td></tr>";



  if($disabled!='disabled'){
   Bootstrap::delete_confirmation(
    "delete_".$each->id."",
    trans('actions.are_you_sure'),
    "<b>".trans('actions.delete_this',['content_type' => 'user']).": </b>".$each->username." <b>?</b>",
    "<a href='".admin_link('user-delete',$each->id)."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
    );
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