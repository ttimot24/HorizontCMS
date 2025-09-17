@extends('layout', ['title' => trans('App center')])

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">

            @include('breadcrumb', [
                'links' => [
                    ['name' => trans('dashboard.content')],
                    ['name' => trans('Plugin manager'), 'url' => route('plugin.index')],
                ],
                'page_title' => trans('Online Store'),
               // 'stats' => [['label' => trans('user.all'), 'value' => count($online_plugins)]],
            ])

            <div class="card-body">

                <div class="row">

                    @if (!$repo_status)
                        <div class="alert alert-warning" role="alert">
                            <div><b>Warning</b> Plugin store unreachable!</div>
                        </div>
                    @endif

                    @foreach ($online_plugins as $o_plugin)
                        <?php $local_plugin = new \App\Model\Plugin($o_plugin->dir); ?>

                        <div class="col-sm-6 col-md-3 mb-3">
                            <div class="card  bg-dark p-2 text-white">
                                <img src="{{ $o_plugin->icon }}" class="img w-100" style='height:10rem;object-fit:cover;'
                                    alt="...">
                                <div class="caption">
                                    <h3 class="mt-3">{{ $o_plugin->info->name }}</h3>
                                    <p>version: {{ $o_plugin->info->version }} author: {{ $o_plugin->info->author }}</p>

                                    @if ($local_plugin->exists() && $local_plugin->getInfo('version') < $o_plugin->info->version)
                                        <p><a href="admin/plugin/download-plugin/{{ $o_plugin->dir }}"
                                                class="btn btn-primary btn-block btn-sm" role="button">Upgrade</a></p>
                                    @elseif($local_plugin->exists() && !$local_plugin->isInstalled())
                                        <p><a href="admin/plugin/install/{{ $o_plugin->dir }}"
                                                class="btn btn-success btn-block btn-sm" role="button">Install</a></p>
                                    @elseif($local_plugin->exists() && $local_plugin->isInstalled())
                                        <p style='height: 30px;'><b>Installed</b></p>
                                    @else
                                        <p><a href="admin/plugin/download-plugin/{{ $o_plugin->dir }}"
                                                class="btn btn-info btn-block btn-sm" role="button">Download</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

        </div>
    @endsection
