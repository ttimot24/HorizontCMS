@extends('layout')

@section('content')
<div class='container'>
<section class="row">
<h1>System log <small class='pull-right' style='margin-top:1.5%;'>Files: {{$all_files->count()}}</small></h1>
<br><br>

<div class='col-md-4'>
 <div class="list-group">
 	@foreach($all_files as $file)
 		  <a href="{{config('horizontcms.backend_prefix')}}/settings/log/{{basename($file)}}" class="list-group-item @if(basename($file)==basename($current_file)) active @endif ">{{basename($file)}}</a>
 
    @if($entry_number==$max_files) 
        @break
    @endif 
 	@endforeach
</div> 
</div>
<div class='col-md-8'>

<?php 

	$colors = [
      'emergency' => 'emergency',
      'alert' => 'alert',
      'critical' => 'danger',
			'error' => 'danger',
      'warning' => 'warning',
      'notice' => 'info',
      'info' => 'info',
      'debug' => 'info'
			];

?>

<div class="well" style="padding:25px;">
    <div class="row">
      <h4 class="col-md-4" >Entries: {{$all_file_entries}}</h4>
      <a href="{{'storage/framework/logs/'.$current_file}}" class="btn btn-primary pull-right"><i class="fa fa-download" aria-hidden="true"></i> Download file</a>
    </div>
    {{'storage/framework/logs/'.$current_file}}
</div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  
@foreach($entries as $entry)

  <div class="panel panel-{{$colors[$entry->level]}}">
    <div class="panel-heading" role="tab" id="heading{{$entry_number}}">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$entry_number}}" @if($loop->first) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse{{$entry_number}}">
             <div class='row'>
              <div class='col-md-8'>#{{$entry_number}}  <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ucfirst($entry->level)}} - {{$entry->id}}</div> <div class='col-md-4 text-right'>{{$entry->date->format(\Settings::get('date_format',\Config::get('horizontcms.default_date_format'),true))}} </div>
        	 </div>
        </a>
      </h4>
    </div>
    <div id="collapse{{$entry_number}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$entry_number}}">
      <div class="panel-body">
      {!! $entry->context !!} 
      </div>
    </div>
  </div>

  <?php  $entry_number--; ?>
@endforeach

</div>


</div>

</section>
</div>

@endsection