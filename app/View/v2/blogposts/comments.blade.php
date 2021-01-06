<h2>{{trans('comment.moderator')}}

@if($blogpost->comments_enabled==1)
<small style='margin-left:20%;'>
  <a type='button' class='btn btn-warning' data-toggle='modal' data-target='#comment-modal-xl'>{{trans('comment.write_comment_button')}}</a>
  <a class='btn btn-danger btn-sm' href="admin/blogpost/disable-comment/{{$blogpost->id}}">{{trans('comment.disable_comments_button')}}</a>
</small>
@endif

<small class='pull-right text-muted pt-2'>{{trans('comment.all_comments')}}: {{$blogpost->comments->count()}}</small></h2></br>


@if($blogpost->comments_enabled!=1)
  <div class="alert alert-warning" role="alert">
  <div class="row">
  <div class="col-md-10" >{!!trans('comment.comments_not_enabled')!!}</div>
  <div class="col-md-2"><a class="btn btn-info btn-sm" href="admin/blogpost/enable-comment/{{$blogpost->id}}">{{ trans('comment.enable_comments_button') }}</a></div>
  </div>
  </div>
@else

<table class='table table-hover'>
    <thead>
      <tr class="d-flex bg-dark text-white">
      	<!--<th>Id</th>-->
        <th class="col">{{trans('comment.th_image')}}</th>
      	<th class="col">{{trans('comment.th_name')}}</th>
      	<th class="col">{{trans('comment.th_comment')}}</th>
        <th class="col">{{trans('comment.th_date')}}</th>
        <th class="col">{{trans('actions.th_action')}}</th>
      </tr>
    </thead><tbody>

<?php 

    foreach($blogpost->comments->reverse() as $comment){

    echo "<tr class='d-flex'>";

    echo "<td class='col'><img class='img-rounded' src='".$comment->user->getThumb()."' width='70'></td>";
    echo "<td class='col'><a href='".admin_link('user-view',$comment->user->id)."'>" .$comment->user->username ."</a></td>";
    echo "<td class='col' style='text-align:justify;'>" .$comment->comment ."</td>";

    echo "<td>" .$comment->created_at->format('Y.m.d') ."</br><font size='2'><i>at ".$comment->created_at->format('H:i:s')."</i></font></td>";
    echo "<td>";


    echo "<div class='btn-group col' role='group'>
           <a href='' type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>".trans('actions.edit')."</a>
           <a type='button' data-toggle='modal' data-target='.delete_".$comment->id."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
       </div>";


    echo "</td>";

    echo "</tr>";


       Bootstrap::delete_confirmation(
        "delete_".$comment->id."",
        "Are you sure?",
        "Do you really want to delete <b>".$comment->user->username."</b>'s comment: ".$comment->comment." ?",
        "<a href='".admin_link('blogpost_comment-delete',$comment->id)."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
        <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
        );


    }

?>

</tbody>
</table>

</br>
</br>

<?php  $user = \Auth::user(); ?>

<div class='modal' id='comment-modal-xl' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-md'>
    <div class='modal-content'>

    <form action="{{admin_link('blogpost_comment-create')}}" method='POST'>
    {{ csrf_field() }}
        <div class='modal-header-warning bg-warning text-white p-2'>
          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
          <h3 class='modal-title m-0'><span class='fa fa-comment-o'></span>  {{trans('comment.write_comment_button')}}</h3>
        </div>
        <div class='modal-body'>
        <h5 style='font-weight:bolder;'>{{trans('comment.write_as')}}: <a href="{{ admin_link('user-view',$user->id) }}" >{{ $user->username }}</a>
        <img src='{{ $user->getThumb() }}' class='img img-rounded pull-right' width='30'></h5>
        <input type='hidden' name='blogpost_id' value='{{ $blogpost->id }}' >
          <textarea style='width:100%;' rows='5' name='comment' required></textarea>
         </div>
        <div class='modal-footer'>
           <button type='submit' class='btn btn-warning'>{{trans('comment.send')}}</button>
        </div>
    </form>
  </div>
</div>
</div>
@endif



