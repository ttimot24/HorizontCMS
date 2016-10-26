@extends('layout')

@section('content')
<div class='container main-container'>

<section class='row'>
<h2 class='col-md-8'>{{trans('user.view_user')}}</h2>

<nav class='col-md-4'>
  <ul class='pager'>


    @if($previous_user)
        <li class='previous' id='prev'><a href='admin/blogpost/show/{{$previous_user}}'> <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span> {{trans('actions.previous')}}</a></li>
    @endif

    @if($next_user)
        <li class='next' id='prev'><a href='admin/blogpost/show/{{$next_user}}'>{{trans('actions.next')}} <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span> </a></li>
    @endif

  </ul>
</nav>
</section>





<section class='row'>
<div class='col-md-3' valign='top'>
<a class='btn btn-link' data-toggle='modal' data-target='.{{$user->id}}-modal-xl'>
  <img src='{{$user->getImage()}}' class='img img-thumbnail' style='margin-top:20px;' >
</a>

</br><center>
  <div class='btn-group' role='group'>
    <a href='admin/{{$user->id}} ' type='button' class='btn btn-success'><span class='glyphicon glyphicon-star' aria-hidden='true'></span> {{trans('actions.deactivate')}}</a>
    <a href='admin/user/update/{{ $user->id }}' type='button' class='btn btn-warning'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> {{trans('actions.edit')}}</a>
  </div>    
    <button type='button' class='btn btn-danger' data-toggle='modal' data-target='.delete'>
    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> {{trans('actions.remove')}}
    </button>

    
    </br></br><b>{{trans('user.full_name')}} : <a>{{ $user->name }}</a></b>
    </br></br><b>{{trans('user.user_name')}} : <a>{{ $user->username }}</a></b>
    </br></br><b>{{trans('user.view_rank')}} : <a>{{ $user->role->name }}</a></b>
     </br></br><b>{{trans('user.view_email')}} : <a>{{ $user->email }}</a></b>
    </br></br><b>{{trans('user.view_registered_on')}} : </br><a>{{ $user->created_at->format('Y.m.d - H:i:s') }}</a></b>
     </br></br><b>{{trans('user.view_logins')}} : <a>{{ $user->visits }}</a></b>
     <hr/>
    </center>
</div>

<div valign='top' class='col-md-9'>

<?php   

  if($user->active==0){

     $datediff = $user->created_at->timestamp - time();
     $days = floor($datediff/(60*60*24));

     $days = ($days<=0)? 0 : $days;

     echo "<div class='panel panel-danger' style='margin-top:4%;'>
            <div class='panel-heading'>
              <h3 class='panel-title'><b>Inactive user</b></h3>
            </div>
              <div class='panel-body'><center><font size='4'>
              ".trans('user.inactive_about',['day_count' => $days])."
              </font></center>
              </div>
            </div>";
  }





  if($user->isAdmin()){

    echo "<h2>".trans('blogpost.blogposts')."(".$user->blogposts->count().")</h2>";

    echo "<table class='table table-condensed table-hover'>
    <thead>
      <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Date</th>
      </tr>
    </thead><tbody>";
  foreach($user->blogposts as $each){

    echo "<tr>";
    echo "<td><a href='admin/blogpost/view/".$each->id."'>";
      echo Html::img($each->getThumb(),"class='img img-thumbnail', width='280' style='object-fit:cover;height:170px;'");
    echo "</a></td>";
    echo "<td><a href='admin/blogpost/view/".$each->id."'>" .$each->title ."</a></td>";
     
    echo "<td>".$each->created_at->format('Y.m.d')."</br><font size='2'><i>at</i> ".$each->created_at->format("H:i:s")."</font></td>";
    echo "</tr>";
    }

    echo "</tbody></table>";

    echo "</div></section>";

    echo "</br></br>";



  }


    Bootstrap::image_details($user->id,$user->getImage());


   Bootstrap::delete_confirmation(
    "delete_".$each->id."",
    trans('actions.are_you_sure'),
    "<b>".trans('actions.delete_this',['content_type' => 'user']).": </b>".$each->username." <b>?</b>",
    "<a href='admin/user/delete/".$each->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
    );


?>



<h2>{{trans('blogpost.comments')}} ({{$user->comments->count()}})</h2>

<table class='table table-condensed table-hover'>
    <thead>
      <tr>
        <th>{{trans('blogpost.post')}}</th>
        <th>{{trans('blogpost.th_comment')}}</th>
        <th>{{trans('blogpost.th_date')}}</th>
      </tr>
    </thead><tbody>

<?php    

  if($user->comments->count()>0){
    foreach($user->comments as $each){

      $news = $each->blogpost;

      if($news!=NULL){

        echo "<tr>";
        echo "<td class='col-md-3'><a href='admin/blogpost/view/".$news->id."'>".$news->title."</a></td>";
        echo "<td class='col-md-8' style='text-align:justify;'>" .$each->comment ."</td>";

        echo "<td class='col-md-1'>".$each->created_at->format('Y.m.d')."</br><font size='2'><i>at</i> ".$each->created_at->format('H:i:s')."</font></td>";
        echo "</tr>";
      }
    }
  }
?>

</tbody></table>

</td></tr></table>


</div>




<script>

$(document).keydown(function(e) {
    switch(e.which) {
        case 37: // left
                 window.location.replace('admin/user/view/{{$previous_user}}');
                 break;

        case 39: // right
                  window.location.replace('admin/user/view/{{$next_user}}');
                  break;

        default: return; // exit this handler for other keys
    
    }
    e.preventDefault();
});


</script>
@endsection