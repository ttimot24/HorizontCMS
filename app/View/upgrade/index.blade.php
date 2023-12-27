@extends('layout')

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">

            @include('breadcrumb', [
                'links' => [['name' => trans('settings.settings'), 'url' => route('settings.index')]],
                'page_title' => trans('System Update Center'),
                'stats' => [
                    ['label'=> 'Current version', 'value' => $current_version]
                ]
            ])

        <div class="card-body">
        <section class='row'>

            <div class='col-md-4'>

                @if ($available_list->isNotEmpty())
                    <a class="btn btn-info w-100"
                        href="{{ config('horizontcms.backend_prefix') }}/settings/sys-upgrade">Install all</a>
                @endif


                <ul class="list-group">

                    @foreach ($available_list as $available)
                        <li class="list-group-item {{$available['tag_name'] === $current_version ? 'active' : '' }}">
                            <h5 class="list-group-item-heading mt-3">Available update: {{ $available['tag_name'] }}</h5>
                            <p class="list-group-item-text">Released at: {{ $available['published_at'] }} | 
                            
                            <a href="{{ route('upgrade.update', $available['tag_name']) }}">Upgrade</a>
                            
                            </p>
                        </li>
                    @endforeach


                    @foreach ($upgrade_list as $available)
                        <li class="list-group-item {{$available['tag_name'] === $current_version ? 'active' : '' }}">
                            <h5 class="list-group-item-heading mt-3">Previous version: {{ $available['tag_name'] }}</h5>
                            <p class="list-group-item-text">Released at: {{ $available['published_at'] }}</p>
                        </li>
                    @endforeach

                </ul>
            </div>

            <div class='col-md-8'>
                <div class="card">
                <div class="card-body"  style='min-height:400px;'>
                    <p>
                    {!! \Str::of($upgrade_list[0]['body'])->markdown() !!}
                    </p>
                </div>
                </div>
            </div>

        </section>

    </div>

    </div>
@endsection
