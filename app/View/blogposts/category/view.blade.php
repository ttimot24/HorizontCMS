@extends('layout')

@section('content')
<div class='container main-container'>
<div class='row'>
<div class='col-md-12'>
<h2>{{trans('category.th_category')}} <small>{{$category->name}}</small></h2>
<br>
<h3>{{trans('category.view_category_blogposts')}} ({{$category->blogposts->count()}})</h3>
<br>
<div>
@foreach($category->blogposts->reverse() as $blogpost)
<div class="col-md-4 mb-3">
    <a href="{{route('blogpost.show',['blogpost' => $blogpost])}}">{{$blogpost->title}}</a>
    @if($blogpost->isDraft())
    <span class="ms-2 badge bg-info">{{trans('actions.draft')}}</span>
    @endif
</div>
@endforeach
</div>
</div>
</div>
</div>
<br><br>
@endsection