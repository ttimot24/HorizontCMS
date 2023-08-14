@extends('layout')

@section('content')
    <div class='container main-container'>

        <div class="card">
            @include('breadcrumb', [
                'links' => [
                    ['name' => 'Content'],
                    ['name' => trans('Themes'), 'url' => route('theme.index')],
                ],
                'page_title' => trans('Online Store'),
            ])

        <div class="container">

            @if (!$repo_status || $repo_status)
                <div class="alert alert-warning" role="alert">
                    <div><b>Warning</b> Theme store unreachable!</div>
                </div>
            @endif


        </div>

        </div>

    </div>
@endsection
