@extends('layout')

@section('content')
<div class='container main-container'>

<section class='row'>
<h2 class='col-md-8'>{{trans('user.view_user')}}</h2>

<nav class='col-md-4'>
  <ul class='pager'>

<?php

/*$indexes = array();

foreach($data['all'] as $each){
	array_push($indexes,$each->id);
}

$key = array_search($user->id,$indexes);


  if(isset($indexes[$key+1])){
  echo "<li class='next' id='next'><a href='admin/user/view/". $indexes[$key+1] ."'>Next <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span></a></li>";
  	}
  if(isset($indexes[$key-1])){
  echo "<li class='next' id='prev'><a href='admin/user/view/". $indexes[$key-1] ."'><span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span> Previous</a></li>";
  }
*/

?>

  </ul>
</nav>
</section>





<section class='row'>
<div class='col-md-3' valign='top'>
<a class='btn btn-link' data-toggle='modal' data-target='.<?= $user->id ?>-modal-xl'>
  <img src='{{$user->getImage() }}' class='img img-thumbnail' style='margin-top:20px;' >
</a>

</br><center>
  <div class='btn-group' role='group'>
    <a href='<?= $user->id ?>' type='button' class='btn btn-success'><span class='glyphicon glyphicon-star' aria-hidden='true'></span> Deactivate</a>
    <a href='user/update/<?= $user->id ?>' type='button' class='btn btn-warning'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> {{trans('actions.edit')}}</a>
  </div>    
    <button type='button' class='btn btn-danger' data-toggle='modal' data-target='.delete'>
    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> {{trans('actions.remove')}}
    </button>

    
    </br></br><b>Full name : <a>{{ $user->name }}</a></b>
    </br></br><b>Username : <a>{{ $user->username }}</a></b>
    </br></br><b>Rank : <a>{{ $user->get_rank()->name }}</a></b>
     </br></br><b>Email : <a>{{ $user->email }}</a></b>
    </br></br><b>Registered on : </br><a>{{ date("Y.m.d - H:i:s",$user->reg_date) }}</a></b>
     </br></br><b>{{trans('user.logins')}} : <a>{{ $user->visits }}</a></b>
     <hr/>
    </center>
</div>

<div valign='top' class='col-md-9'>

<?php   

  if($user->active==0){

     $datediff = $user->reg_date - time();
     $days = floor($datediff/(60*60*24));

     $days<=0? $days=0: $days=$days;

     echo "<div class='panel panel-danger' style='margin-top:4%;'>
            <div class='panel-heading'>
              <h3 class='panel-title'><b>Inactive user</b></h3>
            </div>
              <div class='panel-body'><center><font size='4'>
              This user is inactive about 
              ". $days ." days!
              </font></center>
              </div>
            </div>";
  }





  if($user->rank>3){

    echo "<h2>Posts(".count($data['blogposts']).")</h2>";

    echo "<table class='table table-condensed table-hover'>
    <thead>
      <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Date</th>
      </tr>
    </thead><tbody>";
  foreach($data['blogposts'] as $each){

    echo "<tr>";
    echo "<td><a href='admin/blogpost/view/".$each->id."'>";
      echo Html::img($each->get_thumb(),"class='img img-thumbnail', width='280' style='object-fit:cover;height:170px;'");
    echo "</a></td>";
    echo "<td><a href='admin/blogpost/view/".$each->id."'>" .$each->title ."</a></td>";
     
    echo "<td>".date("Y.m.d",$each->date)."</br><font size='2'><i>at</i> ".date("H:i:s",$each->date)."</font></td>";
    echo "</tr>";
    }

    echo "</tbody></table>";

    echo "</div></section>";

    echo "</br></br>";



  }


    //Bootstrap::image_details($user->id,$user->get_image());


   /* Bootstrap::delete_confirmation(
    "delete",
    "Are you sure?",
    "<b>Delete this user: </b>".$user->username." <b>?</b>",
    "<a href='admin/user/delete/".$user->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>"
    ); */


?>



<h2>Comments (<?= count($data['comments']) ?>)</h2>

<table class='table table-condensed table-hover'>
    <thead>
      <tr>
        <th>Post</th>
        <th>Comment</th>
        <th>Date</th>
      </tr>
    </thead><tbody>

<?php    

  if(count($data['comments'])>0){
    foreach($data['comments'] as $each){

      $news = $each->getBlogpost();

      if($news!=NULL){

        echo "<tr>";
        echo "<td class='col-md-3'><a href='admin/blogpost/view/".$news->id."'>".$news->title."</a></td>";
        echo "<td class='col-md-8' style='text-align:justify;'>" .$each->comment ."</td>";

        echo "<td class='col-md-1'>".date("Y.m.d",$each->date)."</br><font size='2'><i>at</i> ".date("H:i:s",$each->date)."</font></td>";
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
                 window.location.replace('admin/user/view/' + <?= $indexes[$key-1]; ?>);
                 break;

        case 39: // right
                  window.location.replace('admin/user/view/' + <?= $indexes[$key+1]; ?>);
                  break;

        default: return; // exit this handler for other keys
    
    }
    e.preventDefault();
});


</script>
@endsection