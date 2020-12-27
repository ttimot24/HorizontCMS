@extends('layout')

@section('content')
<div class='container main-container'>

<h2>{{trans('blogpost.blogposts')}} <small class='pull-right m-2'>{{trans('blogpost.all')}}: {{$number_of_blogposts}}</small></h2>
<div class='container'>
  <a href="{{admin_link('blogpost-create')}}" class='btn btn-primary mt-3 mb-4'>{{trans('blogpost.new_post_button')}}</a>
</div>

<table class='table table-hover'>
    <thead>
      <tr class="d-flex bg-dark text-white">
      	<th class="col-1">{{trans('blogpost.th_id')}}</th>
        <th class="col-1">{{trans('blogpost.th_image')}}</th>
      	<th class="col-3">{{trans('blogpost.th_title')}}</th>
      	<th class="col-1">{{trans('blogpost.th_comments')}}</th>
        <th class='hidden-xs col-2 text-center'>{{trans('blogpost.th_date')}}</th>
        <th class="col-1">{{trans('blogpost.th_author')}}</th>
        <th class='hidden-xs col-1'>{{trans('blogpost.th_category')}}</th>
        <th class="col-2 text-center">{{trans('actions.th_action')}}</th>
      </tr>
    </thead>
    <tbody>



    <?php foreach($all_blogposts as $blogpost): ?>
        <tr class="d-flex">
          <td class="col-1"><?= $blogpost->id ?></td>
          <td class="col-1"><img src='{{$blogpost->getThumb()}}'  class='img img-rounded' style='object-fit:cover;' width=70 height=50 /> </td>
          <td  class='col-3 col-xs-3'><a href="{{admin_link('blogpost-view',$blogpost->id)}}" >{{ $blogpost->title }}</a><br>
              @if($blogpost->isDraft())
              <span class="badge badge-info">{{trans('actions.draft')}}</span>
              @endif
          </td>
          <td class="col-1 text-center"><span class="badge badge-dark">{{ count($blogpost->comments) }}</span></td>
          <td class='hidden-xs col-2  text-center'><?= $blogpost->created_at->format('Y-m-d'); ?></br><font size='2'><i>at</i> <?= $blogpost->created_at->format('H:i:s'); ?></font></td>
          @if($blogpost->author)
          <td class="col-1"><a href="{{admin_link('user-view',$blogpost->author->id)}}" >{{ $blogpost->author->username }}</a></td>
          @else
          <td>{{ trans('blogpost.removed_user') }}</td>
          @endif
          @if($blogpost->category)
          <td class='hidden-xs col-1'><span class="badge badge-success">{{ $blogpost->category->name }}</span></td>
          @else
          <td class='hidden-xs col-1'>none</td>
          @endif
          <td class="col-2 text-center">
              <div class="btn-group" role="group">
                  <a href="{{admin_link('blogpost-edit',$blogpost->id)}}" type="button" class="btn btn-warning btn-sm" style='min-width:70px;'>{{trans('actions.edit')}}</a>
                  <a type="button" data-toggle='modal' data-target=.delete_<?= $blogpost->id ?> class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
              </div>
          </td>
        </tr>
    <?php 
      Bootstrap::delete_confirmation(
        "delete_".$blogpost->id."",
        trans('actions.are_you_sure'),
        "<b>".trans('actions.delete_this',['content_type'=>'post']).": </b>".$blogpost->title." <b>?</b>",
        "<a href='".admin_link('blogpost-delete',$blogpost->id)."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
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