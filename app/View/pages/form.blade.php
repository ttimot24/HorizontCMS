@extends('layout', ['title' => isset($page)? trans('page.edit_page') : trans('page.new_page'), 'js' => array_merge($js, ['resources/js/pages.js'])])

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">
                    @include('breadcrumb', [
                        'links' => [['name' => 'Content'], ['name' => trans('page.pages'), 'url' => route('page.index')]],
                        'page_title' => trans(isset($page) ? 'page.edit_page' : 'page.add_new_page_title'),
                    ])
            <div class="card-body">

                <form role='form'
                    action="{{ isset($page) ? route('page.update', ['page' => $page]) : route('page.store') }}" method='POST'
                    enctype='multipart/form-data'>

                    @csrf
                    @if (isset($page))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <div class="col-xs-12 col-8">
                            <div class='form-group pull-left col-xs-12 col-md-12'>
                                <label for='title'>{{ trans('page.menu_name') }}</label>
                                <input type='text' class='form-control' id='menu-title' name='name'
                                    onkeyup="ajaxGetSlug();" value="{{ old('name', isset($page) ? $page->name : '') }}"
                                    required>
                                <div class="form-text">
                                    <b>{{ trans('page.semantic_url') }}:</b>&nbsp&nbsp&nbsp{{ rtrim(Config::get('app.url'), '/') }}<a
                                        class='text-muted'
                                        id='ajaxSlug'>{{ isset($page) ? UrlManager::seo_url($page->name) : '' }}</a>
                                </div>
                            </div>

                            <div class='form-group pull-left col-xs-12 col-md-12'>
                                <label for='title'>{{ trans('page.page_template') }}</label>
                                <select class='form-select' name='url'>
                                    <option value=''>{{ trans('page.default_template') }}</option>

                                    @foreach ($page_templates as $template)
                                        <option value='{{ $template }}'
                                            @if (isset($page) && $template == $page->url) selected @endif>
                                            {{ ucfirst(rtrim(rtrim($template, '.php'), '.blade')) }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="row p-3">
                                <div class='form-group col-xs-12 col-md-6'>
                                    <label for='level'>{{ trans('page.page_level') }}</label>
                                    <select class='form-select' name='parent_select' id='level'>
                                        <option value='0' @if (isset($page) && $page->parent_id == null) selected @endif>Main menu
                                        </option>
                                        <option value='1' @if (isset($page) && $page->parent_id != null) selected @endif>Submenu
                                        </option>";
                                    </select>
                                </div>

                                <div class='form-group col-xs-12 col-md-6' id='submenus'>
                                    <label for='submenus'>Parent menu:</label>
                                    <select class='form-select' name='parent_id'>
                                        @foreach ($all_page as $each)
                                            <option value="{{ $each->id }}"
                                                {{ isset($page) && $page->parent != null && $each->is($page->parent) ? 'selected' : '' }}>
                                                {{ $each->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class='form-group col-xs-12 col-md-12' style='margin-top:20px;margin-bottom:20px;'>
                                <label class="m-2 mr-4">{{ trans('page.visibility') }}</label>
                                <div class='form-check form-check-inline'>
                                    <input class="form-check-input" type='radio' id='inlineRadio1' value='1'
                                        name='visibility' @if (!isset($page) || (isset($page) && $page->visibility == 1)) checked @endif>
                                    <label class="form-check-label" for='inlineRadio1'> {{ trans('page.visible') }}
                                    </label>
                                </div>
                                <div class='form-check form-check-inline'>
                                    <input class="form-check-input" type='radio' id='inlineRadio2' value='0'
                                        name='visibility' @if (isset($page) && $page->visibility == 0) checked @endif>
                                    <label class="form-check-label" for='inlineRadio2'> {{ trans('page.invisible') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">

                            @if (isset($page) && $page->hasImage())
                                <button type='button' class='btn btn-link mb-5 w-100' data-bs-toggle='modal'
                                    data-bs-target='#modal-xl-{{ $page->id }}'>
                                    <img src='{{ $page->getThumb() }}' class='img img-thumbnail w-100'>
                                </button>
                            @endif

                            <div class='form-group'>
                                <label for='file'>{{ trans('actions.upload_image') }}:</label>
                                <input name='up_file' accept='image/*' id='input-2' type='file' class='file'
                                    multiple='true'
                                    data-drop-zone-enabled="{{ isset($page) && $page->hasImage() ? 'false' : 'true' }}"
                                    data-show-upload='false' data-show-caption='true'>
                            </div>

                        </div>


                        <div class='form-group pull-left col-xs-12 col-md-12'>
                            <label for='text'>{{ trans('page.page_content') }}</label>

                            <text-editor id="texteditor" :name="'page'"
                                :data="'{{ remove_linebreaks(old('page', isset($page) ? $page->page : '')) }}'"
                                :language="'{{ config('app.locale') }}'"
                                :filebrowserBrowseUrl="'{{ route('filemanager.index', ['path' => 'images/pages', 'mode' => 'embed']) }}'"
                                :filebrowserUploadUrl="'{{ route('filemanager.store', ['module' => 'pages']) }}'">
                            </text-editor>

                        </div>

                        <div class='form-group pull-left col-xs-12 col-md-8'>
                            <button id='submit-btn' type='submit'
                                class='btn btn-primary btn-lg'>{{ trans(isset($page) ? 'actions.update' : 'actions.publish') }}</button>
                        </div>
                    </div>




                </form>

            </div>
        </div>

    </div>

    @if (isset($page) && $page->hasImage())
        @include('image_details', ['modal_id' => $page->id, 'image' => $page->getImage()])
    @endif

@endsection

@section('head')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    <script type='text/javascript' defer>

            $(document).ready(function() {

                if ($('#level').find('option:selected').val() == '1') {
                    $('#submenus').show();
                }

                $('#level').change(function() {
                    if ($(this).find('option:selected').val() == '0') {
                        $('#submenus').hide();

                    } else {

                        $('#submenus').show();
                    }
                });
            });
    </script>
    
@endsection