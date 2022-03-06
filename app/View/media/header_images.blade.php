@extends('layout')

@section('content')
<div class='container main-container'>

	<div class="row">

		<div class='col-md-10'>
			<h2>Header images</h2>
		</div>

		<div class='col-md-2 my-auto'>
			<a id='upl' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='.upload_images'><i class='fa fa-upload'></i>&nbspUpload images</a>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class='jumbotron' style='padding:2%;padding-left:3%;background-color:#31708F;color:white;'>
		<h4>Currently on the slider:</h4>

		<div class="row">

			@if(!$slider_images->isEmpty())
				@foreach($slider_images as $image)
					<div class='col-md-3'>
					   	<div class="img img-thubmnail bg-white p-3">
							<img src='storage/images/header_images/{{ $image->image }}' alt='' class='img-rounded' width='100%' height='120px'>
							<p style="color:#000;margin:0px;padding:0px;overflow:hidden;font-size:12px;" class="py-2">{{$image->image}}</p>
							<a class='btn btn-danger btn-xs btn-block' href='admin/header-image/delete/{{ $image->id }}'>Remove from slider</a>
					   	</div>
					</div>
				@endforeach
			@else
				<h4 class='text-center'><br>No images on the slider!<br></h4>
			@endif
		</div>

	</div>
<hr>
<div class='container'>
	<h3>Available images:</h3>
<div class="row">
	@foreach($dirs as $each)
		<div class='col-md-3 img img-thumbnail p-2 float-left' style='margin-bottom:3%;height:180px;'>
			<a class='btn-sm btn-success col-md-6' href='admin/header-image/create/{{ $each }}'>Add to slider</a>
			<a href='admin/file-manager/delete?file=storage/images/header_images/{{$each}}' class='pull-right'>
				<span class='fa fa-trash' aria-hidden='true' style=' font-size: 1.4em;z-index:15;top:3px;right:3px;margin-bottom:-15px;'></span>
			</a>

			@if($each!="" && !is_dir('storage/images/header_images/{{ $each }}'))
			<img src='storage/images/header_images/{{ $each }}' alt='' class='img-rounded mt-2' width='100%' height='75%;'>
			@endif
			<p style="color:white;margin:0px;padding:0px;overflow:hidden;">{{$each}}</p>
		</div>
	@endforeach
</div>
</div>


</div>


<div class='modal upload_images' id='create_file' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary bg-primary'>
	 	<h4 class='modal-title text-white'>Upload images</h4>
		<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
	  </div>
	  <form action='admin/file-manager/fileupload?dir_path=storage/images/header_images' method='POST' enctype='multipart/form-data'>
      <div class='modal-body'>
		{{ csrf_field() }}
		<div class='form-group'>
		<label for='file'>Upload file:</label>
		<input name='up_file[]' id='input-2' type='file' class='file'  accept="image/*"  multiple='true' data-show-upload='false' data-show-caption='true' required>
		</div>


      </div>
      <div class='modal-footer'>
		<button type='submit' class='btn btn-primary'>{{trans('actions.upload')}}</button>
        <button type='button' class='btn btn-default' data-bs-dismiss='modal'>{{trans('actions.cancel')}}</button>
	  </div>
	  </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection