@extends('layout')

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">

            @include('breadcrumb', [
                'links' => [['name' => 'Content'], ['name' => trans('Plugins'), 'url' => route('plugin.index')]],
                'page_title' => trans('Plugin manager'),
                'stats' => [['label' => trans('user.all'), 'value' => $all_plugin->count()]],
                'buttons_right' => [
                    [
                        'icon' => 'fa-cloud-download',
                        'label' => 'Download apps',
                        'route' => config('horizontcms.backend_prefix') . '/plugin/onlinestore',
                        'class' => 'btn-info',
                    ],
                    [
                        'icon' => 'fa-upload',
                        'label' => 'Upload plugin',
                        'class' => 'btn-primary',
                        'data' =>
                            'data-bs-toggle=modal data-bs-target=.upload_plugin ' .
                            ($zip_enabled ? '' : 'disabled'),
                    ],
                ],
            ])


            <div class="card-body">

                    @foreach ($all_plugin as $current_plugin)
                    <div class='card mb-3'>
                        <div class='card-body p-3 bg-dark'>
                            <div class='row p-0'>
                                <div class='col-md-1 col-sm-12 col-xs-12 p-0 pl-3 text-center'>
                                    <img src="{{ $current_plugin->getIcon() }}" class='img img-thumbnail mt-1' style='width: 5rem; height: 5rem;' />
                                </div>

                                <div class='col-md-9 m-0'>
                                    <h4 class='p-0'>

                                        @if ($current_plugin->isActive())
                                            <a class='card-title text-primary' id='{{ $current_plugin->root_dir }}'
                                                href='{{ route('plugin.'.str_slug($current_plugin->root_dir).'.start.index') }}'>{{ $current_plugin->getName() }}</a>
                                        @else
                                            <a class='text-white'
                                                id='{{ $current_plugin->root_dir }}'>{{ $current_plugin->getName() }}</a>
                                        @endif


                                        <small class='text-muted'>version: {{ $current_plugin->getInfo('version') }}
                                            | author: <a href='{{ $current_plugin->getInfo('author_url') }}'>
                                                {{ $current_plugin->getInfo('author') }}</a>
                                        </small>
                                    </h4>

                                    <p class='text-white'>
                                        {{ $current_plugin->getInfo('description') }}
                                    </p>

                                </div>

                                <div class='col-md-2 col-sm-4 col-xs-4 text-end'>


                                    @if (!$current_plugin->isInstalled())
                                        <a id='install' class='btn btn-primary btn-block'
                                            href='{{ config('horizontcms.backend_prefix') }}/plugin/install/{{ $current_plugin->root_dir }}'>Install</a>
                                    @else
                                        @if (!$current_plugin->isActive())
                                            <a class='btn btn-success btn-block'
                                                href='{{ config('horizontcms.backend_prefix') }}/plugin/activate/{{ $current_plugin->root_dir }}'>Activate</a>
                                        @else
                                            <a class='btn btn-info btn-block'
                                                href='{{ config('horizontcms.backend_prefix') }}/plugin/deactivate/{{ $current_plugin->root_dir }}'>Deactivate</a>
                                        @endif
                                    @endif



                                    <button class='btn btn-danger btn-block' data-bs-toggle='modal'
                                        data-bs-target='#delete_{{ $current_plugin->root_dir }}'>{{ trans('actions.delete') }}</button>


                                </div>

                            </div>

                        </div>

                        </div>


                        @include('confirm_delete', [
                            'route' => route('plugin.destroy', ['plugin' => $current_plugin->root_dir]),
                            'id' => 'delete_' . $current_plugin->root_dir,
                            'header' => trans('actions.are_you_sure'),
                            'name' => $current_plugin->getName(),
                            'content_type' => 'plugin',
                            'delete_text' => trans('actions.delete'),
                            'cancel' => trans('actions.cancel'),
                        ])
                    @endforeach


                <div class='modal upload_plugin' id='create_file' tabindex='-1' role='dialog'
                    aria-labelledby='myModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header modal-header-primary bg-primary'>
                                <h4 class='modal-title text-white'>New file</h4>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                    aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>

                                <form action="{{ config('horizontcms.backend_prefix') }}/plugin/upload" method='POST'
                                    enctype='multipart/form-data'>
                                    @csrf
                                    <div class='form-group'>
                                        <label for='file'>Upload file:</label>
                                        <input name='up_file[]' id='input-2' type='file' class='file' accept='.zip'
                                            multiple='true' data-show-upload='false' data-show-caption='true'>
                                    </div>


                            </div>
                            <div class='modal-footer'>
                                <button type='submit' class='btn btn-primary'>Upload</button></form>
                                <button type='button' class='btn btn-default'
                                    data-bs-dismiss='modal'>{{ trans('actions.cancel') }}</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->



            </div>

        </div>
    @endsection
