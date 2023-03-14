@extends('layout')

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">
            <div class="card-header fw-bold">

                <div class="row">

                    <div class='col-md-10'>
                        <h2>{{ trans('Header images') }}</h2>
                    </div>

                    <div class='col-md-2 my-auto d-flex justify-content-end'>
                        <a id='upl' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='.upload_images'><i
                                class='fa fa-upload'></i>&nbspUpload images</a>
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>

            <div class="card-body">

                <div class='jumbotron text-white' style='padding:3rem;background-color:#31708F;'>
                    <h4>Currently on the slider:</h4>

                    <div class="row">

                        @if ($slider_images->count() > 0)
                            @foreach ($slider_images as $each)
                                <div class="card col-md-3 pt-3">
                                    <a class='d-flex justify-content-end me-2 mb-4' data-bs-toggle='modal'
                                        data-bs-target='#headline-image-{{ $each->id }}'>
                                        <span class='fa fa-pencil' aria-hidden='true'
                                            style=' font-size: 1.4em;z-index:15;top:3px;right:3px;margin-bottom:-15px;'></span>
                                    </a>
                                    <img src='storage/images/header_images/{{ $each->image }}' alt=''
                                        class='card-img-top' width='100%' height='75%;' style="object-fit:cover;">
                                    <div class="card-body text-black">
                                        <h5 class="card-title">{{ $each->title }}</h5>
                                    </div>
                                    <ul class="list-group list-group-flush mb-3">
                                        <a class='btn btn-danger btn-xs btn-block'
                                            href='admin/header-image/remove-from-slider/{{ $each->id }}'>Remove from
                                            slider</a>
                                    </ul>
                                </div>


                                <div class='modal edit_images' id='headline-image-{{ $each->id }}' tabindex='-1'
                                    role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                    <div class='modal-dialog modal-xl'>
                                        <div class='modal-content'>
                                            <div class='modal-header modal-header-primary bg-primary'>
                                                <h4 class='modal-title text-white'>Edit headline</h4>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                                    aria-label='Close'></button>
                                            </div>
                                            <form action='admin/header-image/edit/{{ $each->id }}' method='POST'>
                                                <div class='modal-body text-dark'>
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="header-image-title" class="form-label">Tagline</label>
                                                        <input type="text" class="form-control" name="title"
                                                            id="header-image-title" value="{{ $each->title }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="header-image-title" class="form-label">Link</label>
                                                        <input type="text" class="form-control" name="link"
                                                            id="header-image-title" value="{{ $each->link }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlTextarea1"
                                                            class="form-label">Summary</label>
                                                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5">{{ $each->description }}</textarea>
                                                    </div>

                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='submit'
                                                        class='btn btn-primary'>{{ trans('actions.save') }}</button>
                                                    <button type='button' class='btn btn-default'
                                                        data-bs-dismiss='modal'>{{ trans('actions.cancel') }}</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
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
                        @foreach ($slider_disabled as $each)
                            <div class="card col-md-3">
                                <div class="card-header py-2 px-0 bg-white">
                                    <div class="row">
                                        <div class="col-9">
                                            <a class='btn-sm'
                                                href='admin/header-image/add-to-slider/{{ $each->id }}'>Add to
                                                slider</a>
                                        </div>
                                        <div class="col-1">
                                            <a href="#" data-bs-toggle='modal' data-bs-target='#headline-image-{{ $each->id }}'>
                                                <span class='fa fa-pencil' aria-hidden='true'
                                                    style=' font-size: 1.4em;z-index:15;'></span>
                                            </a>
                                        </div>
                                        <div class="col-2">
                                            <form action="{{ route('headerimage.destroy', ['headerimage' => $each]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0">
                                                    <span class='fa fa-trash' aria-hidden='true'
                                                        style='font-size: 1.4em;z-index:15;'></span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <img src='storage/images/header_images/{{ $each->image }}' alt=''
                                    class='card-img-top' width='100%' height='75%;' style="object-fit:cover;">
                                <div class="card-body text-black">
                                    <h5 class="card-title">{{ $each->title }}</h5>
                                </div>
                            </div>


                            <div class='modal edit_images' id='headline-image-{{ $each->id }}' tabindex='-1'
                                role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog modal-xl'>
                                    <div class='modal-content'>
                                        <div class='modal-header modal-header-primary bg-primary'>
                                            <h4 class='modal-title text-white'>Edit headline</h4>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'
                                                aria-label='Close'></button>
                                        </div>
                                        <form action='{{ route('headerimage.update', ['headerimage' => $each]) }}'
                                            method='POST'>
                                            <div class='modal-body'>
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="header-image-title" class="form-label">Tagline</label>
                                                    <input type="text" class="form-control" name="title"
                                                        id="header-image-title" value="{{ $each->title }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="header-image-title" class="form-label">Link</label>
                                                    <input type="text" class="form-control" name="link"
                                                        id="header-image-title" value="{{ $each->link }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlTextarea1"
                                                        class="form-label">Summary</label>
                                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5">{{ $each->description }}</textarea>
                                                </div>

                                            </div>
                                            <div class='modal-footer'>
                                                <button type='submit'
                                                    class='btn btn-primary'>{{ trans('actions.save') }}</button>
                                                <button type='button' class='btn btn-default'
                                                    data-bs-dismiss='modal'>{{ trans('actions.cancel') }}</button>
                                            </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        @endforeach
                    </div>
                </div>

            </div>


            <div class='modal upload_images' id='create_file' tabindex='-1' role='dialog'
                aria-labelledby='myModalLabel' aria-hidden='true'>
                <div class='modal-dialog modal-xl'>
                    <div class='modal-content'>
                        <div class='modal-header modal-header-primary bg-primary'>
                            <h4 class='modal-title text-white'>Upload images</h4>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'
                                aria-label='Close'></button>
                        </div>
                        <form action="{{ route('headerimage.store') }}" method='POST' enctype='multipart/form-data'>
                            <div class='modal-body'>
                                @csrf
                                <div class='form-group'>
                                    <label for='file'>Upload file:</label>
                                    <input name='up_file' id='input-2' type='file' class='file' accept="image/*"
                                        multiple='true' data-show-upload='false' data-show-caption='true' required>
                                </div>
                                <div class="mb-3">
                                    <label for="header-image-title" class="form-label">Tagline</label>
                                    <input type="text" class="form-control" name="title" id="header-image-title">
                                </div>
                                <div class="mb-3">
                                    <label for="header-image-title" class="form-label">Link</label>
                                    <input type="text" class="form-control" name="link" id="header-image-title"
                                        value="{{ $each->link }}">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlTextarea1" class="form-label">Summary</label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5"></textarea>
                                </div>

                            </div>
                            <div class='modal-footer'>
                                <button type='submit' name="active" value="0"
                                    class='btn btn-primary'>{{ trans('actions.upload') }}</button>
                                <button type='button' class='btn btn-default'
                                    data-bs-dismiss='modal'>{{ trans('actions.cancel') }}</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div>
    </div>

@endsection
