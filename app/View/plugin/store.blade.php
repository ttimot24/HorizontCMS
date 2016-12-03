@extends('layout')

@section('content')
<div class='container main-container'>


<h1>Online Store</h1>
<hr>
<br>

<div class="row">

@foreach($online_plugins as $o_plugin)


	  <div class="col-sm-6 col-md-3">
	    <div class="thumbnail">
	      <img src="{{ $o_plugin->icon }}" style='width:100%;height:150px;object-fit:cover;' alt="...">
	      <div class="caption">
	        <h3>{{ $o_plugin->info->name }}</h3>
	        <p>version: {{ $o_plugin->info->version }} author: {{ $o_plugin->info->author }}</p>
	        <p><a href="admin/plugin/download/<?php //$o_plugin->info->dir; ?>" class="btn btn-info btn-block" role="button">Download</a></p>
	      </div>
	    </div>
	  </div>

@endforeach

	</div>

</div>
@endsection
