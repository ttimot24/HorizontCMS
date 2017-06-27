@extends('layout')

@section('content')
<div class='container'>
<section class="row">
<h1>Logs</h1>
<br><br>

<div class='col-md-4'>
 <div class="list-group">
 	@foreach($all_files as $file)
 		  <a href="settings/log/{{basename($file)}}" class="list-group-item">{{basename($file)}}</a>
 	@endforeach
</div> 
</div>
<div class='col-md-8'>

<?php 

	$colors = [
			'ERROR' => 'danger',
			];

?>


<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  
@for($i=count($last_log['date'])-1;$i>0;$i--)

  <div class="panel panel-{{$colors[$last_log['level'][$i]]}}">
    <div class="panel-heading" role="tab" id="heading{{$i}}">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}" @if($i==0) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse{{$i}}">
             <div class='row'>
             <div class='col-md-6'><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$last_log['level'][$i]}} </div> <div class='col-md-6 text-right'>{{$last_log['date'][$i]}} </div>
        	 </div>
        </a>
      </h4>
    </div>
    <div id="collapse{{$i}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading{{$i}}">
      <div class="panel-body">
      {{$last_log['message'][$i]}} 
      </div>
    </div>
  </div>

@endfor

</div>


</div>

</section>
</div>

@endsection