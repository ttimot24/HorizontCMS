@extends('layout')

@section('content')
<div class='container main-container'>


<h1>Online Store</h1>
<hr>
<br>

<div class="row">

@foreach($online_plugins as $o_plugin)

	  <?php $local_plugin = new \App\Model\Plugin($o_plugin->dir) ?>

	  <div class="col-sm-6 col-md-3">
	    <div class="thumbnail">
	      <img src="{{ $o_plugin->icon }}" style='width:100%;height:150px;object-fit:cover;' alt="...">
	      <div class="caption">
	        <h3>{{ $o_plugin->info->name }}</h3>
	        <p>version: {{ $o_plugin->info->version }} author: {{ $o_plugin->info->author }}</p>

	        @if( \App\Model\Plugin::exists($o_plugin->dir) && $local_plugin->getInfo('version') < $o_plugin->info->version )
	        <p><a href="admin/plugin/download-plugin/{{ $o_plugin->dir }}" class="btn btn-primary btn-block" role="button">Upgrade</a></p>
	        @elseif(\App\Model\Plugin::exists($o_plugin->dir) && !$local_plugin->isInstalled())
	        <p><a href="admin/plugin/install/{{ $o_plugin->dir }}" class="btn btn-success btn-block" role="button">Install</a></p>
	       	@elseif(\App\Model\Plugin::exists($o_plugin->dir) && $local_plugin->isInstalled())
	       	<p><b>Installed</b></p>
	        @else
	        <p><a href="admin/plugin/download-plugin/{{ $o_plugin->dir }}" class="btn btn-info btn-block" role="button">Download</a></p>
	        @endif
	      </div>
	    </div>
	  </div>

@endforeach

	</div>

</div>
@endsection
