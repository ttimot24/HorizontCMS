@extends('layout')

@section('content')
<div class='container main-container'>

<div class='row'>
<div class='col-md-8'>
<h1>System Update Center</h1>
</div>

<div class='col-md-4'>
<br>
	  <a class="list-group-item active">
	    <h4 class="list-group-item-heading">Current version: v{{$current_version->version}}</h4>
	    <p class="list-group-item-text">Installed: {{$current_version->created_at}}</p>
	  </a>

</div>
</div>

<br><br>

<section class='row'>

<div class='col-md-4' style='/*max-height:400px;overflow-y:scroll;padding:0px;border:1px solid #9d9d9d;border-radius:5px;*/'>
	<div class="list-group">
	  
<!--	<?php //if($data['latest_version'] > $data['current_version']->version): ?>
	  <a class="list-group-item list-group-item-warning" style='border-radius:0px;'>
	    <h4 class="list-group-item-heading">Latest available: v<?php // $data['latest_version'] ?></h4>
	    <p class="list-group-item-text">Upgrade</p>
	  </a>
	<?php// endif; ?>-->

	@foreach($available_list as $available)
	  <a class="list-group-item">
	    <h4 class="list-group-item-heading">Available update: v{{$available}}</h4>
	    <p class="list-group-item-text">Upgrade</p>
	  </a>
	@endforeach


	  @foreach($upgrade_list as $upgrade)

	   @if($loop->first)
		  <a class="list-group-item active">
		    <h4 class="list-group-item-heading">Current Version: v{{$upgrade->version}}</small></h4>
		    <p class="list-group-item-text">Installed: {{$upgrade->created_at}}</p>
		  </a>
		  <?php continue; ?>
	   @elseif($loop->last)
		   <a class="list-group-item list-group-item-success" style='border-radius:0px;cursor:pointer;'>
		    <h4 class="list-group-item-heading">System Core: {{$upgrade->version}}</h4>
		    <p class="list-group-item-text">Installed: {{$upgrade->created_at}}</p>
		  </a>
		  <?php continue; ?>
	   @endif

	   <a class="list-group-item">
	    <h4 class="list-group-item-heading">{{ $upgrade->importance }} Update: v{{ $upgrade->version }} <small>build: {{$upgrade->build }}</small></h4>
	    <p class="list-group-item-text">Installed: {{$upgrade->created_at}}</p>
	  </a>



	 @endforeach
	</div>
</div>

<div class='col-md-8' style='border: 1px solid #9d9d9d;height:400px;'>
</div>

</section>

</div>

<br><br><br>
@endsection