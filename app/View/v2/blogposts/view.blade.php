@extends('layout')

@section('content')
<div class='container main-container'>


<section class='row'>
<h1 class='col-md-9'>{{trans('blogpost.view_blogpost')}}</h1>

<nav id="arrows" class='col-xs-12 col-md-3 pt-4'>
  <ul class='pager list-unstyled'>

    @if($previous_blogpost)
        <li class='btn previous float-left' v-on:keyup.left="previous"><a class="rounded-pill bg-dark px-3 py-2 text-white" href="{{admin_link('blogpost-view',$previous_blogpost)}}"> <span class='fa fa-angle-left' aria-hidden='true'></span> {{trans('actions.previous')}}</a></li>
    @endif

    @if($next_blogpost)
        <li class='btn next float-right' v-on:keyup.right="next"><a class="rounded-pill bg-dark px-3 py-2 text-white" href="{{admin_link('blogpost-view',$next_blogpost)}}">{{trans('actions.next')}} <span class='fa fa-angle-right' aria-hidden='true'></span> </a></li>
    @endif


  </ul>
</nav>
</section>


<section class='row'>
<div class='col-md-4'>
  <button type='button' class='btn btn-link' data-toggle='modal' data-target='.{{ $blogpost->id }}-modal-xl'>
    <img src='{{ $blogpost->getImage() }}' width='350' class='img img-thumbnail mt-3'  />
  </button>

  <div class="text-center">
    <div class='btn-group my-3' role='group'>
      <a href='#' type='button' class='btn btn-success'><span class='glyphicon glyphicon-star' aria-hidden='true'></span> {{trans('blogpost.primary')}}</a>
      <a href="{{admin_link('blogpost-edit',$blogpost->id)}}" type='button' class='btn btn-warning'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> {{trans('actions.edit')}} </a>
      
      <button type='button' class='btn btn-danger' data-toggle='modal' data-target='.delete'>
      <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> {{trans('actions.remove')}}
      </button>
    </div>

    @if($blogpost->isDraft())
      <span class="badge badge-info d-block mb-3" style='font-size:14px;'>{{trans('actions.draft')}}</span>
    @endif

      @if($blogpost->author)
      <b class="d-block mb-3">{{trans('blogpost.author')}} :  <a href="{{admin_link('user-view',$blogpost->author->id)}}">{{ $blogpost->author->username }}</a></b>
      @else
      <b class="d-block mb-3">{{trans('blogpost.author')}} : <a class="color-primary"> {{ trans('blogpost.removed_user') }} </a> </b>
      @endif 

      <b class="d-block mb-3">{{trans('blogpost.slug')}} :  <a class="color-primary">{{ $blogpost->getSlug() }}</a></b>
      <b class="d-block mb-3">{{trans('blogpost.published_on')}} :  <a class="color-primary">{{ $blogpost->created_at->format(\Settings::get('date_format',\Config::get('horizontcms.default_date_format'),true)) }}</a></b>
    
    @if($blogpost->category)  
      <b class="d-block mb-3">{{trans('blogpost.category')}} :  <a class="color-primary" href="{{ admin_link('blogpost_category-view',$blogpost->category->id) }}">{{ $blogpost->category->name }}</a></b>
    @endif
      <b class="d-block mb-3">{{trans('blogpost.reading_time')}} : <a class="color-primary">{{ ceil($blogpost->getReadingTime()/60) }} mins</a></b>
      <b class="d-block mb-3">{{trans('blogpost.characters')}} : <a class="color-primary">{{ $blogpost->getTotalCharacterCount() }}</a></b>
      <b class="d-block mb-3">{{trans('blogpost.words')}} : <a class="color-primary">{{ $blogpost->getTotalWordCount() }}</a></b>
      <b class="d-block mb-3">{{trans('blogpost.comments')}} : <a class="color-primary">{{ $blogpost->comments->count() }}</a></b>
  </div>
</div>

<div class="col-md-8 mt-4">
  <div class='well bg-dark text-white p-4 overflow-auto'>
    <h3>{{ $blogpost->title }}</h3><hr/>
    <b>{{ $blogpost->summary }}</b>
    <p class="pt-4">
    {!! $blogpost->text !!}
    </p>
  </div>  
</div>

</section>
<div id='comments'></div>



<?php 

  Bootstrap::image_details($blogpost->id,$blogpost->getImage());

  Bootstrap::delete_confirmation(
    "delete",
    trans('actions.are_you_sure'),
    "<b>".trans('actions.delete_this',['content_type'=>'post']).": </b>". $blogpost->title." <b>?</b>",
    "<a href='".admin_link('blogpost-delete',$blogpost->id)."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
    );

?>


@include('blogposts.comments')


</div>


<script>

var arrow = new Vue({
  el: '#arrows',
  data:{

  },
  methods:{
    previous: function(){
       window.location.replace("{{ admin_link('blogpost-view',$previous_blogpost) }}");
    },
    next: function(){
      window.location.replace("{{admin_link('blogpost-view',$next_blogpost)}}");
    }
  },
  beforeCreate: function(){
    console.log("Vue started.");
  }
});

</script>



@endsection