@extends('layout')

@section('content')
<div class='container'>
<h2 class="mb-5">System log <small class='pull-right'>Files: {{$all_files->count()}}</small></h2>

<section class="row">


<div class='col-md-4'>
    <div class="list-group">
      @foreach($all_files as $file)
          <a href="{{config('horizontcms.backend_prefix')}}/settings/log/{{basename($file)}}" class="list-group-item @if(basename($file)==basename($current_file))  bg-primary border-0 text-white @endif">{{basename($file)}}</a>
    
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

<div class="card bg-dark text-white mb-4 p-4">
    <div class="row">
      <h4 class="col-md-4" >Entries: {{$all_file_entries}}</h4>
      @if(isset($current_file))
      <a href="{{'storage/framework/logs/'.$current_file}}" class="btn btn-primary ml-auto"><i class="fa fa-download" aria-hidden="true"></i> Download file</a>
      @endif
    </div>
    {{'storage/framework/logs/'.$current_file}}
</div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  
@foreach($entries as $entry)


<div class="card">
    <div class="card-header bg-{{$colors[$entry->level]}}" id="heading{{$entry_number}}">
        <h6 class="text-white" data-toggle="collapse" data-target="#collapse{{$entry_number}}" aria-expanded="true" aria-controls="collapse{{$entry_number}}">
          <div class='col-md-8 text-left float-left'>
            #{{$entry_number}}  <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ucfirst($entry->level)}} - {{$entry->id}}
            </div> 
            <div class='col-md-4 text-right float-right'>
              {{$entry->date->format(\Settings::get('date_format',\Config::get('horizontcms.default_date_format'),true))}}
            </div>
        </h6>
    </div>

    <div id="collapse{{$entry_number}}" class="collapse @if($loop->first) show @else nshow @endif" aria-labelledby="heading{{$entry_number}}" data-parent="#accordion">
      <div class="card-body bg-dark text-white">
      {!! $entry->context !!} 
      </div>
    </div>
  </div>

<!--
  <div class="panel panel-{{$colors[$entry->level]}}">
    <div class="panel-heading" role="tab" id="heading{{$entry_number}}">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$entry_number}}" @if($loop->first) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse{{$entry_number}}">
             <div class='row'>
                <div class='col-md-8'>
                    <h6>#{{$entry_number}}  <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ucfirst($entry->level)}} - {{$entry->id}} </h6>
                  </div> 
                  <div class='col-md-4 text-right'>
                    <h6>{{$entry->date->format(\Settings::get('date_format',\Config::get('horizontcms.default_date_format'),true))}} </h6>
                  </div>
        	 </div>
        </a>
      </h4>
    </div>
    <div id="collapse{{$entry_number}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$entry_number}}">
      <div class="panel-body">
      {!! $entry->context !!} 
      </div>
    </div>
  </div>-->

  <?php  $entry_number--; ?>
@endforeach

</div>


</div>

</section>
</div>

@endsection