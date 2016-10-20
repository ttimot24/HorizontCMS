@extends('layout')

@section('content')
<div class='container main-container'>

<h2>{{trans('blogpost.blogposts')}} <small class='pull-right' style='margin-top:1.5%;'>{{trans('blogpost.all')}}: {{$number_of_blogposts}}</small></h2></br>
<div class='container'>
  <a href='admin/blogpost/create' class='btn btn-primary' style='margin-bottom:20px;'>{{trans('blogpost.new_post_button')}}</a>
</div>

<table class='table table-hover'>
    <thead>
      <tr>
      	<th>{{trans('blogpost.th_id')}}</th>
        <th>{{trans('blogpost.th_image')}}</th>
      	<th>{{trans('blogpost.th_title')}}</th>
      	<th>{{trans('blogpost.th_comments')}}</th>
        <th>{{trans('blogpost.th_date')}}</th>
        <th>{{trans('blogpost.th_author')}}</th>
        <th>{{trans('blogpost.th_category')}}</th>
        <th><center>{{trans('actions.th_action')}}</center></th>
      </tr>
    </thead><tbody>



<?php foreach($all_blogposts as $blogpost): ?>

<tr>
  <td><?= $blogpost->id ?></td>


  <td><img src='{{$blogpost->getThumb()}}'  class='img img-rounded' style='object-fit:cover;' width=70 height=50 /> </td>


  <td  class='col-md-5'><a href='admin/blogpost/show/{{ $blogpost->id }}' >{{ $blogpost->title }}</a></td>
  		 <td><center><span class="badge" style='font-size:14px'>{{ count($blogpost->comments) }}</span></center></td>
  

  <td><?= $blogpost->created_at->format('Y-m-d'); ?></br><font size='2'><i>at</i> <?= $blogpost->created_at->format('H:i:s'); ?></font></td>
         <td><a href='admin/user/show/{{ $blogpost->author->id }}' >
         {{ $blogpost->author->username }}</a></td>
         <td><span class="label label-success" style='font-size:14px; display:block'>{{ $blogpost->category->name }}</span></td>



  <td>
    <center>

       <div class="btn-group" role="group">
           <a href='admin/blogpost/edit/{{ $blogpost->id }}' type="button" class="btn btn-warning btn-sm" style='min-width:70px;'>{{trans('actions.edit')}}</a>
           <a type="button" data-toggle='modal' data-target=.delete_<?= $blogpost->id ?> class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
       </div>

        </center>
  </td>
</tr>

<?php 

   Bootstrap::delete_confirmation(
    "delete_".$blogpost->id."",
    trans('actions.are_you_sure'),
    "<b>".trans('actions.delete_this',['content_type'=>'post']).": </b>".$blogpost->title." <b>?</b>",
    "<a href='admin/blogpost/delete/".$blogpost->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
    );

?>


<?php endforeach; ?>


</tbody>
  </table>

    <center>
        {{$all_blogposts->links()}}
    </center>

</div>
@endsection