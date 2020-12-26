@extends('layout')

@section('content')
<div class='container main-container'>

<div class="row py-4">


<h2 class='col-md-8'>{!!trans('search.found_matches',['quantity' => ($search_engine->getTotalCount() ), 'search_word' => $search_for ])!!}</h2> 

<div class='col-md-4 col-sm-12 my-auto'>
  <form class='form-inline' action='admin/search' method='POST'>
    {{ csrf_field() }}
      <div class='form-group'>
        <div class='input-group'>
        <input type='text' pattern=".{3,}" title="Minimum 3 characters" class='form-control' name='search' id='exampleInputAmount' placeholder="{{ trans('dashboard.search_bar') }}" required>
          <div class="input-group-prepend">
              <button type='submit' class='btn btn-link btn-sm border-0' style='padding:0px;'>
                  <span class='fa fa-search text-white' aria-hidden='true' ></span>
                </button>
            </div>
        </div>
      </div>
      <!-- <button type='submit' class='btn btn-primary'>Search</button>-->
  </form>

</div>
</div>

@if(\Auth::user()->hasPermission('blogpost'))
<h3 style='clear:both;'>{{trans('blogpost.blogposts')}} ({{$search_engine->getResultsFor(\App\Model\Blogpost::class)->count()}})</h3>
<div class='container'>
@foreach($search_engine->getResultsFor(\App\Model\Blogpost::class) as $each)
  <a href="{{config('horizontcms.backend_prefix')}}/blogpost/show/{{$each->id}}">{{$each->title}}</a><br/>
@endforeach
</div>
@endif


@if(\Auth::user()->hasPermission('user'))
<h3>{{trans('user.users')}} ({{$search_engine->getResultsFor(\App\Model\User::class)->count()}})</h3>
<div class='container'>
@foreach($search_engine->getResultsFor(\App\Model\User::class) as $each)
  <a href="{{config('horizontcms.backend_prefix')}}/user/show/{{$each->id}}">{{$each->username}}</a><br/>
@endforeach
</div>
@endif


@if(\Auth::user()->hasPermission('page'))
<h3>{{trans('page.pages')}} ({{$search_engine->getResultsFor(\App\Model\Page::class)->count()}})</h3>
<div class='container'>
@foreach($search_engine->getResultsFor(\App\Model\Page::class) as $each)
  <a href="{{config('horizontcms.backend_prefix')}}/page/show/{{$each->id}}">{{$each->name}}</a><br/>
@endforeach
</div>
@endif



@if(\Auth::user()->hasPermission('media'))
<h3>{{trans('file.files')}} ({{count($files)}})</h3>
<div class='container'>
<?php 
  /*  foreach ($files as $each) {
      echo "<a href=''>" .$each ."</a></br>";
    }*/
?>
</div>
@endif


<br/><br/><br/><br/><br/>
@endsection