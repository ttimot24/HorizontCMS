<div class='container'>
	@if(session()->has('message'))
		@foreach(session()->get('message') as $key => $value)
		<div class="alert alert-{{ $key }} alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

		  @if($key == 'success')
		  <span class='glyphicon glyphicon-ok' aria-hidden='true'></span> 
		  @elseif($key == 'danger')
		  <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
		  @elseif($key == 'warning')
		  <span class='glyphicon glyphicon-warning-sign' aria-hidden='true'></span>
		  @elseif($key == 'info')
		  <span class='glyphicon glyphicon-info-sign' aria-hidden='true'></span>
		  @endif

		  <strong>{{ ucfirst($key) }}!</strong> {{ $value }}
		</div>
		@endforeach
	@endif
</div>