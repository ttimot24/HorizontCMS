@extends('layout')

@section('content')
<div class='container main-container'>
<div class='row'>
<div class='col-md-12'>
<h1>{{trans('category.th_category')}} <small>{{$category->name}}</small></h1>
<br>
<h3>{{trans('category.view_category_blogposts')}} ({{$category->blogposts->count()}})</h3>
<br>
<div>
@foreach($category->blogposts as $blogpost)
    <a href="{{admin_link('blogpost-view',$blogpost->id)}}" class="col-md-4">{{$blogpost->title}}</a>
@endforeach
</div>
</div>
</div>
</div>
<br><br>
@endsection