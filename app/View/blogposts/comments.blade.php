
<div class="row mt-5 mb-3">
  <h2 class="col">{{trans('comment.moderator')}}</h2>
  @if($blogpost->comments_enabled==1)
  <div class="col">
    <a type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#comment-modal-xl'>{{trans('comment.write_comment_button')}}</a>
    <a class='btn btn-danger btn-sm' href="admin/blogpost/disable-comment/{{$blogpost->id}}">{{trans('comment.disable_comments_button')}}</a>
  </div>
  @endif
  <div class='col text-muted pt-2 text-end fs-5'>{{trans('comment.all_comments')}}: {{$blogpost->comments->count()}}</div>
</div>

@if($blogpost->comments_enabled!=1)
  <div class="alert alert-warning" role="alert">
    <div class="row">
      <div class="col-9" >{!!trans('comment.comments_not_enabled')!!}</div>
      <div class="col-3 text-end"><a class="btn btn-info btn-sm" href="admin/blogpost/enable-comment/{{$blogpost->id}}">{{ trans('comment.enable_comments_button') }}</a></div>
    </div>
  </div>
@else

<table class='table table-hover'>
    <thead>
      <tr class="bg-dark text-white">
      	<!--<th>Id</th>-->
        <th class="col">{{trans('comment.th_image')}}</th>
      	<th class="col">{{trans('comment.th_name')}}</th>
      	<th class="col">{{trans('comment.th_comment')}}</th>
        <th class="col">{{trans('comment.th_date')}}</th>
        <th class="col text-center">{{trans('actions.th_action')}}</th>
      </tr>
    </thead><tbody>

    @foreach($blogpost->comments->reverse() as $comment)

    <tr>
      <td class='col'><img class='img-rounded' src='{{ $comment->user->getThumb() }}' width='70'></td>
      <td class='col'><a href="{{ route('user.show',[ 'user' => $comment->user]) }}">{{ $comment->user->username }}</a></td>
      <td class='col' style='text-align:justify;'>{{ $comment->comment }}</td>
      <td>{{ $comment->created_at->format('Y.m.d') }} </br><font size='2'><i>at {{ $comment->created_at->format('H:i:s') }}</i></font></td>
      
      <td class="text-center">
        <div class='btn-group col' role='group'>
              <a href='#' type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>{{ trans('actions.edit') }}</a>
              <a type='button' data-bs-toggle='modal' data-bs-target='#delete_{{$comment->id}}' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
        </div>
      </td>
    </tr>

    <form method='POST' action="{{route('blogpostcomment.destroy',['blogpostcomment' => $comment])}}"> 
      @csrf 
      @method('delete')

      <?php 

       Bootstrap::delete_confirmation([
        "id" => "delete_".$comment->id,
        "header" => "Are you sure?",
        "body" => "Do you really want to delete <b>".$comment->user->username."</b>'s comment: ".$comment->comment." ?",
        "footer" => "<button type='submit' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</button>",
        "cancel" => trans('actions.cancel')
        ]);

      ?>
    </form>

    @endforeach

</tbody>
</table>

<div class='modal' id='comment-modal-xl' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-md'>
    <div class='modal-content'>
        <div class='modal-header-warning bg-warning text-white p-2'>
          <button type='button' class='btn-close col-md-6 float-end' data-bs-dismiss='modal' aria-label='Close'></button>
          <h4 class='modal-title col-md-6'><span class='fa fa-comment-o'></span>  {{trans('comment.write_comment_button')}}</h4>
        </div>
        
        <form action="{{route('blogpostcomment.store')}}" method='POST'>
        @csrf
        <div class='modal-body'>
        <h5 style='font-weight:bolder;'>{{trans('comment.write_as')}}: <a href="{{ route('user.show',['user' => $user]) }}" >{{ $user->username }}</a>
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



