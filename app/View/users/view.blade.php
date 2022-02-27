@extends('layout')

@section('content')
<div class='container main-container'>

<section class='row'>
  <h2 class='col-md-9'>{{trans('user.view_user')}}</h2>
 
  <nav id="arrows" class='col-md-3 pt-4'>
    <ul class='pager list-unstyled'>


      @if($previous_user)
          <li class='previous float-start' v-on:keyup.left="previous"><a class="rounded-pill bg-dark px-3 py-2 text-white" href="{{admin_link('user-view',$previous_user)}}"> <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span> {{trans('actions.previous')}}</a></li>
      @endif

      @if($next_user)
          <li class='next float-end' v-on:keyup.right="next"><a class="rounded-pill bg-dark px-3 py-2 text-white" href="{{admin_link('user-view',$next_user)}}">{{trans('actions.next')}} <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span> </a></li>
      @endif

    </ul>
  </nav>
</section>





<section class='row'>
<div class='col-md-3 text-center' valign='top'>
<a class='btn btn-link' data-bs-toggle='modal' data-bs-target='#modal-xl-{{$user->id}}'>
  <img src='{{$user->getImage()}}' class='img img-thumbnail mt-3' >
</a>

  <div class='btn-group my-3' role='group'>
    <a href='admin/{{$user->id}}' type='button' class='btn btn-success mx-1'><span class='glyphicon glyphicon-star' aria-hidden='true'></span> {{trans('actions.deactivate')}}</a>
    <a href="{{admin_link('user-edit',$user->id)}}" type='button' class='btn btn-warning'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> {{trans('actions.edit')}}</a>
  </div>    
  @if($user->role_id<\Auth::user()->role_id && !$user->is(Auth::user()))
    <button type='button' class='btn btn-danger my-3' data-bs-toggle='modal' data-bs-target='#delete_{{$user->id}}'>
      <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> {{trans('actions.remove')}}
    </button>
  @endif

     <b class="d-block text-center mb-3">{{trans('user.view_full_name')}} : <a class="color-primary">{{ $user->name }}</a></b>
     <b class="d-block text-center mb-3">{{trans('user.view_user_name')}} : <a class="color-primary">{{ $user->username }}</a></b>
     <b class="d-block text-center mb-3">{{trans('user.view_rank')}} : <a>{{ $user->role->name }}</a></b>
     <b class="d-block text-center mb-3">{{trans('user.view_email')}} : <a class="color-primary">{{ $user->email }}</a></b>
     <b class="d-block text-center mb-3">{{trans('user.view_registered_on')}} : </br><a class="color-primary">{{ $user->created_at->format(\Settings::get('date_format',\Config::get('horizontcms.default_date_format'),true)) }}</a></b>
     <b class="d-block text-center mb-3">{{trans('user.view_logins')}} : <a class="color-primary">{{ $user->visits }}</a></b>
     <hr/>
</div>

<div valign='top' class='col-md-9'>

<?php   

  if(!$user->isActive()){

     echo "<div class='panel panel-danger' style='margin-top:4%;'>
            <div class='panel-heading'>
              <h3 class='panel-title'><b>Inactive user</b></h3>
            </div>
              <div class='panel-body' style='text-align:center;'><font size='4'>
              ".trans('user.inactive_about',['day_count' => $user->created_at->diffForHumans()])."
              </font> <a href='admin/user/activate/".$user->id."' class='btn btn-sm btn-danger pull-right'>Force activate</a>
              </div>
          </div>";
  }





  if($user->isAdmin()){

    echo "<h2>".trans('blogpost.blogposts')."(".$user->blogposts->count().")</h2>";

    echo "<table class='table table-condensed table-hover'>
    <thead>
      <tr class='d-flex bg-dark text-white'>
        <th class='col-4'>Image</th>
        <th class='col-6'>Title</th>
        <th class='col-2'>Date</th>
      </tr>
    </thead>
    <tbody>";


  foreach($user->blogposts->reverse() as $each){

    echo "<tr class='d-flex'>";
    echo "<td class='col-4'><a href='".admin_link('blogpost-view',$each->id)."'>";
      echo Html::img($each->getThumb(),"class='img img-thumbnail bg-dark', width='250' style='object-fit:cover;height:150px;'");
    echo "</a></td>";
    echo "<td class='col-6'>
            <a href='".admin_link('blogpost-view',$each->id)."'><h5>" .$each->title ."</h5></a>
            <p>".$each->summary."</p>
         </td>";
     
    echo "<td class='col-2 text-right'>".$each->created_at->format('Y.m.d')."</br><font size='2'><i>at</i> ".$each->created_at->format("H:i:s")."</font></td>";
    echo "</tr>";
  }
  
    echo "</tbody></table>";

    echo "</div></section>";

    echo "</br></br>";



}



   Bootstrap::image_details($user->id,$user->getImage());


   Bootstrap::delete_confirmation([
    "id" => "delete_".$user->id."",
    "header" => trans('actions.are_you_sure'),
    "body" => "<b>".trans('actions.delete_this',['content_type' => 'user']).": </b>".$user->username." <b>?</b>",
    "footer" => "<a href='".admin_link('user-delete',$user->id)."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>",
    "cancel" => trans('actions.cancel')
   ]);


?>



<h2>{{trans('blogpost.comments')}} ({{$user->comments->count()}})</h2>

<table class='table table-condensed table-hover'>
    <thead>
      <tr class="d-flex bg-dark text-white">
        <th class="col-3">{{trans('blogpost.post')}}</th>
        <th class="col-8">{{trans('blogpost.th_comment')}}</th>
        <th class="col-1">{{trans('blogpost.th_date')}}</th>
      </tr>
    </thead><tbody>

<?php    

    foreach($user->comments as $each){

      if($each->blogpost!=NULL){

        echo "<tr class='d-flex'>";
        echo "<td class='col-3'><a href='".admin_link('blogpost-view',$each->blogpost->id)."'>".$each->blogpost->title."</a></td>";
        echo "<td class='col-8' style='text-align:justify;'>" .$each->comment ."</td>";

        echo "<td class='col-1'>".$each->created_at->format('Y.m.d')."</br><font size='2'><i>at</i> ".$each->created_at->format('H:i:s')."</font></td>";
        echo "</tr>";
      }
    }

?>

</tbody>
</table>

</div>

</div></section>

<script>

var arrow = new Vue({
  el: '#arrows',
  data:{

  },
  methods:{
    previous: function(){
       window.location.replace("{{admin_link('user-view',$previous_user)}}");
    },
    next: function(){
      window.location.replace("{{admin_link('user-view',$next_user)}}");
    }
  },
  beforeCreate: function(){
    console.log("Vue started.");
  }
});

</script>

@endsection