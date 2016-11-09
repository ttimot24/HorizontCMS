@extends('layout')

@section('content')
<div class='container main-container'>
<h2>Header images</h2>


</br></br>
<form action='admin/headerimage/upload' method='POST' enctype='multipart/form-data'>

{{ csrf_field() }}

<div class='form-group'>
      <label for='file'>Upload file:</label>
      <input name='up_file[]' id='input-2' type='file' accept='image/*' class='file' multiple='true' data-show-upload='true' data-show-caption='true'>
    </div>
</form>

    </br></br>

<div class='container'>
	<h3>Currently on the slider:</h3>



	@if(!$slider_images->isEmpty())
		@foreach($slider_images as $image)
			<div class='img-thumbnail col-md-3' style='height:150px;'>
			<img src='storage/images/header_images/{{ $image->image }}' alt='' class='img-rounded' width='100%' height='85%;'>
			<a class='btn btn-danger btn-xs btn-block' href='admin/headerimage/delete/{{ $image->id }}'>Remove from slider</a>
			</div>
		@endforeach
	@else
		 <h4> No images on the slider!</h4>
	@endif


</div>

<div class='container'>
	<h3>Available images:</h3>


@foreach($dirs as $each)
	<div class='col-md-3 img img-thumbnail'  style='margin-bottom:5%;height:200px;'>
	<a class='btn-sm btn-success col-md-6' href='admin/headerimage/create/{{ $each }}'>Add to slider</a>
	<a href='admin/headerimage/destroy/{{ $each }}' class='pull-right'>
	<span class='glyphicon glyphicon-remove' aria-hidden='true' style=' font-size: 1.4em;z-index:15;top:3px;right:3px;margin-bottom:-15px;'></span></a>

	<img src='storage/images/header_images/{{ $each }}' alt='' class='img-rounded' width='100%' height='80%;'>
	</div>
@endforeach


</div>


</br></br></br>


</div>
@endsection