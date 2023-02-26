@extends('layout')

@section('content')
<div class='container main-container'>

<h2>{{trans('user.registered_users')}} <small class='pull-right text-muted pt-3'>{{trans('user.all')}}: {{$number_of_users}} | {{trans('user.active')}}: {{$active_users}} | {{trans('user.inactive')}}: {{$number_of_users-$active_users}}</small></h2>


<div class='container col-md-12'><a href="{{route('user.create')}}" class='btn btn-warning mb-3'>{{trans('user.new_user_button')}}</a></div>

<table class='table table-hover'>
    <thead>
      <tr class="bg-dark text-white">
      	<th>{{trans('user.th_id')}}</th>
      	<th>{{trans('user.th_image')}}</th>
        <th>{{trans('user.th_name')}}</th>
        <th>{{trans('user.th_username')}}</th>
        <th>{{trans('user.th_email')}}</th>
        <th class="text-center">{{trans('user.th_rank')}}</th>
        <th class="text-center">{{trans('user.th_session')}}</th>
        <th class="text-center">{{trans('actions.th_action')}}</th>
      </tr>
    </thead>
    <tbody>

<?php 

foreach($all_users as $each){

echo $each->active==0? "<tr class='bg-danger'>" : "<tr>" ;

echo "<td>". $each->id ."</td>";
echo "<td>";
echo Html::img($each->getImage(),"class='img-rounded' style='object-fit:cover;' width='50' height='50'");
echo	"</td>";

echo "<td><a href='".route('user.show',['user' => $each])."'>".$each->name."</a></td>";
echo "<td>".$each->username."</td>";
echo "<td>".$each->email."</td>";

        echo "<td> 
                <span class='d-block badge rounded-pill ".( ($each->isAdmin())? "bg-danger" : "bg-dark" ) ."' style='font-size:13px;'>".$each->role->name ."</span>
             </td>";
        echo "<td style='text-align:center;'><b>"; 





        if($each->isOnline()){
          echo "<p class='text-success'>Online</p>";	
        }
        else{
          echo "<p class='text-danger'>Offline</p>";	
        }


echo   "</b></td><td class='text-center'>";

$disabled = "";
      if($each->role_id>=\Auth::user()->role_id || $each->is(Auth::user())){
        $disabled='disabled';
      }   

echo "
       <div class='btn-group' role='group'>
           <a href='".route('user.edit',['user' => $each])."' type='button' class='btn btn-warning btn-sm ".$disabled."' style='min-width:70px;' ".$disabled.">".trans('actions.edit')."</a>";
         
           echo "<a type='button' data-bs-toggle='modal' data-bs-target='#delete_".$each->id."' class='btn btn-danger btn-sm ".$disabled."' ".$disabled."><i class='fa fa-trash-o' aria-hidden='true'></i></a>";

echo "</div>";

      
      echo "</td></tr>";



  if($disabled!='disabled'){


    ?>
  
    <form method='POST' action="{{route('user.destroy',['user' => $each])}}"> 
        @csrf 
        @method('delete')
  
        <?php 
    
        Bootstrap::delete_confirmation([
          "id" => "delete_".$each->id."",
          "header" =>trans('actions.are_you_sure'),
          "body" => "<b>".trans('actions.delete_this',['content_type' => 'user']).": </b>".$each->username." <b>?</b>",
          "footer" => "<button type='submit' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</button>",
          "cancel" => trans('actions.cancel')
        ]);

        ?>
    </form>

   <?php

 }


}

?>



  </tbody>
</table>


    <div class="d-flex justify-content-center">
        {{$all_users->links()}}
    </div>

</div>
@endsection