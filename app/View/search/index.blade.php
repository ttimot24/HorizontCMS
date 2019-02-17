@extends('layout')

@section('content')
<div class='container main-container'>

<h2 class='col-md-8'>{!!trans('search.found_matches',['quantity' => ($blogposts->count()+$users->count()+$pages->count()+count($files)),
                                                                       'search_word' => $search_for ])!!}</h2> 

<div class='col-md-4 col-sm-12'>
<form class='form-inline' action='admin/search' method='POST'>
    {{ csrf_field() }}
<br>
          <div class='form-group'>
            <div class='input-group'>
            <input type='text' pattern=".{3,}" title="Minimum 3 characters" class='form-control' name='search' id='exampleInputAmount' placeholder="{{ trans('dashboard.search_bar') }}" required>
               <div class='input-group-addon'>
                <button type='submit' class='btn btn-link btn-sm'  style='margin:0px;padding:0px;'>
               <span class='glyphicon glyphicon-search' aria-hidden='true' size=1></span></div>
               </button>
            </div>
          </div>
         <!-- <button type='submit' class='btn btn-primary'>Search</button>-->
        </form>

</br></br></br>
</div>


@if(\Auth::user()->hasPermission('blogpost'))
<h3 style='clear:both;'>{{trans('blogpost.blogposts')}} ({{$blogposts->count()}})</h3>
<div class='container'>
@foreach($blogposts as $each)
  <a href='admin/blogpost/show/{{$each->id}}'>{{$each->title}}</a></br>
@endforeach
</div>
@endif


@if(\Auth::user()->hasPermission('user'))
<h3>{{trans('user.users')}} ({{$users->count()}})</h3>
<div class='container'>
@foreach($users as $each)
  <a href='admin/user/show/{{$each->id}}'>{{$each->username}}</a></br>
@endforeach
</div>
@endif


@if(\Auth::user()->hasPermission('page'))
<h3>{{trans('page.pages')}} ({{$pages->count()}})</h3>
<div class='container'>
@foreach($pages as $each)
  <a href='admin/page/show/{{$each->id}}'>{{$each->name}}</a></br>
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


</br></br></br></br></br>
@endsection