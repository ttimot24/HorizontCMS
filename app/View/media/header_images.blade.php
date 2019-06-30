@extends('layout')

@section('content')
<div class='container main-container'>

<div class='col-md-10'>
  <h1>Header images</h1>
</div>

<div class='col-md-2'>
  <br>
  <a id='upl' class='btn btn-primary' data-toggle='modal' data-target='.upload_images'><i class='fa fa-upload'></i>&nbspUpload images</a>
</div>

<div class="clearfix"></div>

<div class='container'>
<div class='jumbotron' style='padding:2%;padding-left:3%;background-color:#31708F;color:white;'>
	<h4>Currently on the slider:</h4>

<div class="row">

	@if(!$slider_images->isEmpty())
		@foreach($slider_images as $image)
			<div class='img-thumbnail col-md-3' style='height:180px;'>
			<img src='storage/images/header_images/{{ $image->image }}' alt='' class='img-rounded' width='100%' height='75%;'>
			<p style="color:white;margin:0px;padding:0px;overflow:hidden;font-size:12px;">{{$image->image}}</p>
			<a class='btn btn-danger btn-xs btn-block' href='admin/header-image/delete/{{ $image->id }}'>Remove from slider</a>
			</div>
		@endforeach
	@else
		 <h4 style="text-align:center;"><br>No images on the slider!<br></h4>
	@endif
</div>

</div>
</div>
<hr>
<div class='container'>
	<h3>Available images:</h3>


@foreach($dirs as $each)
	<div class='col-md-3 img img-thumbnail' style='margin-bottom:3%;height:200px;'>
	<a class='btn-sm btn-success col-md-6' href='admin/header-image/create/{{ $each }}'>Add to slider</a>
	<a href='admin/file-manager/delete?file=storage/images/header_images/{{$each}}' class='pull-right'>
	<span class='glyphicon glyphicon-remove' aria-hidden='true' style=' font-size: 1.4em;z-index:15;top:3px;right:3px;margin-bottom:-15px;'></span></a>

	@if($each!="" && !is_dir('storage/images/header_images/{{ $each }}'))
	<img src='storage/images/header_images/{{ $each }}' alt='' class='img-rounded' width='100%' height='75%;'>
	@endif
	<p style="color:white;margin:0px;padding:0px;overflow:hidden;">{{$each}}</p>
	</div>
@endforeach


</div>


</br></br></br>


</div>


<div class='modal upload_images' id='create_file' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Upload images</h4>
	  </div>
	  <form action='admin/file-manager/fileupload?dir_path=storage/images/header_images' method='POST' enctype='multipart/form-data'>
      <div class='modal-body'>
		{{csrf_field()}}
		<div class='form-group'>
		<label for='file'>Upload file:</label>
		<input name='up_file[]' id='input-2' type='file' class='file'  accept="image/*"  multiple='true' data-show-upload='false' data-show-caption='true' required>
		</div>


      </div>
      <div class='modal-footer'>
		<button type='submit' class='btn btn-primary'>{{trans('actions.upload')}}</button>
        <button type='button' class='btn btn-default' data-dismiss='modal'>{{trans('actions.cancel')}}</button>
	  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection