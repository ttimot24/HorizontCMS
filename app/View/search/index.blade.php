@extends('layout', ['title' => trans('search.title')])

@section('content')
    <div class='container main-container'>

    <div class="card pb-5">

            @include('breadcrumb', [
                'links' => [['name' => 'Content'], ['name' => trans('Dashboard'), 'url' => route('dashboard.index')]],
                'page_title' => trans('search.title'),
            ])

    <div class="container">
        <div class="row py-4">


            <h2 class='col-md-8'>{!! trans('search.found_matches', ['quantity' => $search_engine->getTotalCount(), 'search_word' => $search_for]) !!}</h2>

            <div class='col-md-4 col-sm-12 my-auto pt-3'>
                <form class='form-inline' action="{{ route('search.show', ['search' => 'search']) }}" method="GET">
                    @csrf
                    <div class='form-group'>
                        <div class='input-group'>
                            <input type='text' pattern=".{3,}" title="Minimum 3 characters" class='form-control'
                                name='search' id='exampleInputAmount' placeholder="{{ trans('dashboard.search_bar') }}"
                                required>
                            <div class="input-group-prepend">
                                <button type='submit' class='btn btn-link btn-sm border-0 p-0'>
                                    <span class='fa fa-search text-white' aria-hidden='true'></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- <button type='submit' class='btn btn-primary'>Search</button>-->
                </form>

            </div>
        </div>

        @if (\Auth::user()->hasPermission('blogpost'))
            <h3 style='clear:both;'>{{ trans('blogpost.blogposts') }}
                ({{ count($search_engine->getResultsFor(\App\Model\Blogpost::class)) }})</h3>
            <div class='container'>
                @foreach ($search_engine->getResultsFor(\App\Model\Blogpost::class) as $each)
                    <a href="{{ route('blogpost.show', ['blogpost' => $each]) }}">{{ $each->title }}</a><br />
                @endforeach
            </div>
        @endif


        @if (\Auth::user()->hasPermission('user'))
            <h3>{{ trans('user.users') }} ({{ count($search_engine->getResultsFor(\App\Model\User::class)) }})</h3>
            <div class='container'>
                @foreach ($search_engine->getResultsFor(\App\Model\User::class) as $each)
                    <a href="{{ route('user.show', ['user' => $each]) }}">{{ $each->username }}</a><br />
                @endforeach
            </div>
        @endif


        @if (\Auth::user()->hasPermission('page'))
            <h3>{{ trans('page.pages') }} ({{ count($search_engine->getResultsFor(\App\Model\Page::class)) }})</h3>
            <div class='container'>
                @foreach ($search_engine->getResultsFor(\App\Model\Page::class) as $each)
                    <a href="{{ route('page.show', ['page' => $each]) }}">{{ $each->name }}</a><br />
                @endforeach
            </div>
        @endif



        @if (\Auth::user()->hasPermission('media'))
            <h3>{{ trans('file.files') }} ({{ count($files) }})</h3>
            <div class='container'>
            </div>
        @endif


        </div>

        </div>
        </div>
    @endsection
