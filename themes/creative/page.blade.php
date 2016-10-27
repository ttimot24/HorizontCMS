@extends('theme::index')

@section('content')

	<h1>{{$_REQUESTED_PAGE->name}}</h1>
	<p><h1>{!!$_REQUESTED_PAGE->page!!}</h1></p>

@endsection