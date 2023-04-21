@extends('layout')

@section('content')
    <div class='container main-container'>
        <div class="card mb-3">
            <div class="card-header fw-bold">
                <h2>{{ trans(isset($blogpost) ? 'blogpost.edit_blogpost' : 'blogpost.new_blogpost') }}</h2>
            </div>
            <div class="card-body">

                <form role='form'
                    action="{{ isset($blogpost) ? route('blogpost.update', ['blogpost' => $blogpost]) : route('blogpost.store') }}"
                    method='POST' enctype='multipart/form-data'>

                    @csrf
                    @if (isset($blogpost))
                        @method('PUT')
                    @endif

                    <div class="row">

                        <div class="col-xs-12 col-md-8">

                            <div class='form-group pull-left col-12'>
                                <label for='title'>{{ trans('blogpost.title') }}:</label>
                                <input type='text' class='form-control' id='title' name='title'
                                    value="{{ old('title', isset($blogpost) ? $blogpost->title : '') }}" required>
                            </div>

                            <div class='form-group pull-left col-6'>
                                <label for='sel1'>{{ trans('blogpost.select_category') }}:</label>
                                <select class='form-select' name='category_id' id='sel1'>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ isset($blogpost) && $category->is($blogpost->category) ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class='form-group pull-left col-12'>
                                <label for='title'>{{ trans('blogpost.summary') }}:</label>
                                <input type='text' class='form-control' id='title' name='summary'
                                    value="{{ old('summary', isset($blogpost) ? $blogpost->summary : '') }}"></br>
                            </div>

                        </div>
                        <div class="col-md-4 col-sm-12">

                            @if (isset($blogpost) && $blogpost->hasImage())
                                <button type='button' class='btn btn-link mb-5 w-100' data-bs-toggle='modal'
                                    data-bs-target='#modal-xl-{{ $blogpost->id }}'>
                                    <img src='{{ $blogpost->getThumb() }}' class='img img-thumbnail w-100'>
                                </button>
                            @endif

                            <div class='form-group'>
                                <label for='file'>{{ trans('actions.upload_image') }}:</label>
                                <input name='up_file' accept='image/*' id='input-2' type='file' class='file'
                                    multiple='true'
                                    data-drop-zone-enabled="{{ isset($blogpost) && $blogpost->hasImage() ? 'false' : 'true' }}"
                                    data-remove-class="btn btn-default" data-show-upload='false' data-show-caption='true'>
                            </div>

                        </div>

                        <div class="col-12">
                            <div class='form-group pull-left col-12'>
                                <label for='text'>{{ trans('blogpost.post') }}:</label>
                                <text-editor id="texteditor" :name="'text'"
                                    :data="'{{ remove_linebreaks(old('blogpost', isset($blogpost) ? $blogpost->text : '')) }}'"
                                    :language="'{{ config('app.locale') }}'"
                                    :filebrowserBrowseUrl="'{{ route('filemanager.index', ['path' => 'images/blogposts', 'mode' => 'embed']) }}'"
                                    :filebrowserUploadUrl="'{{ route('filemanager.store', ['module' => 'blogpost']) }}'">
                                </text-editor>
                            </div>

                            <div class='form-group col-12'>

                                @if (!isset($blogpost))
                                    <button name="active" value="1" id='submit-btn' type='submit'
                                        class='btn btn-primary btn-lg'
                                        onclick='window.onbeforeunload = null;'>{{ trans('actions.publish') }}</button>
                                    <button name="active" value="0" id='submit-btn' type='submit'
                                        class='btn btn-info'
                                        onclick='window.onbeforeunload = null;'>{{ trans('actions.save_draft') }}</button>
                                @else
                                    <button id='submit-btn' name='active'
                                        value="{{ isset($blogpost) && $blogpost->isDraft() ? 0 : 1 }}" type='submit'
                                        class='btn btn-success btn-lg'
                                        onclick='window.onbeforeunload = null;'>{{ trans('actions.update') }}</button>
                                    @if ($blogpost->isDraft())
                                        <button name="active" value="1" id='submit-btn' name='submit_clicked'
                                            type='submit' class='btn btn-primary btn-lg'
                                            onclick='window.onbeforeunload = null;'>{{ trans('actions.publish') }}</button>
                                    @endif
                                @endif
                                <a href="{{ route('blogpost.index') }}" type='button'
                                    class='btn btn-default'>{{ trans('actions.cancel') }}</a>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>

    @if (isset($blogpost) && $blogpost->hasImage())
        @include('image_details', ['modal_id' => $blogpost->id, 'image' => $blogpost->getImage()])
    @endif

@endsection
