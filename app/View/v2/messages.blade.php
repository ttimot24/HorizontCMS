<div class='container my-3'>

	@if(\App\HorizontCMS::isInstalled() && \Auth::check() && \Settings::get('admin_broadcast') != '')
	<div class="alert alert-info alert-dismissible" role="alert">
	      <i class="bi bi-info-circle-fill"></i>
		  <strong>Broadcast message: </strong> {{ \Settings::get('admin_broadcast') }}
	</div>
	@endif

	@if(session()->has('message'))
		@foreach(session()->get('message') as $key => $value)
		<div class="alert alert-{{ $key }} alert-dismissible" role="alert">

		  @if($key == 'success')
		  <i class="bi bi-check-circle-fill"></i> 
		  @elseif($key == 'danger')
		  <i class="bi bi-exclamation-circle-fill"></i>
		  @elseif($key == 'warning')
		  <i class="bi bi-exclamation-triangle-fill"></i>
		  @elseif($key == 'info')
		  <i class="bi bi-info-circle-fill"></i>
		  @endif

		  <strong>{{ ucfirst($key) }}!</strong> {{ $value }}
		  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		@endforeach
	@endif
</div>
