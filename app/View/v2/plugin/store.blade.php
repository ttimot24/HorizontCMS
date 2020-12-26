@extends('layout')

@section('content')
<div class='container main-container'>


<h1>Online Store</h1>
<hr>

<div class="row">

<?php 
if(!$repo_status){

  echo (new BootstrapMessage())->warning("Plugin store unreachable!"); 
}

?>

@foreach($online_plugins as $o_plugin)

	  <?php $local_plugin = new \App\Model\Plugin($o_plugin->dir) ?>

	  <div class="col-sm-6 col-md-3 mb-3">
	    <div class="thumbnail  bg-dark p-2 text-white">
	      <img src="{{ $o_plugin->icon }}" style='width:100%;height:150px;object-fit:cover;' alt="...">
	      <div class="caption">
	        <h3 style='height:50px;'>{{ $o_plugin->info->name }}</h3>
	        <p>version: {{ $o_plugin->info->version }} author: {{ $o_plugin->info->author }}</p>

	        @if( $local_plugin->exists() && $local_plugin->getInfo('version') < $o_plugin->info->version )
	        <p><a href="admin/plugin/download-plugin/{{ $o_plugin->dir }}" class="btn btn-primary btn-block btn-sm" role="button">Upgrade</a></p>
	        @elseif( $local_plugin->exists() && !$local_plugin->isInstalled())
	        <p><a href="admin/plugin/install/{{ $o_plugin->dir }}" class="btn btn-success btn-block btn-sm" role="button">Install</a></p>
	       	@elseif( $local_plugin->exists() && $local_plugin->isInstalled())
	       	<p style='height: 30px;'><b>Installed</b></p>
	        @else
	        <p><a href="admin/plugin/download-plugin/{{ $o_plugin->dir }}" class="btn btn-info btn-block btn-sm" role="button">Download</a></p>
	        @endif
	      </div>
	    </div>
	  </div>

@endforeach

	</div>

</div>
@endsection
