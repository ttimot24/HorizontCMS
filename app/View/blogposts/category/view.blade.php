@extends('layout')

@section('content')
    <div class='container main-container'>
        <div class='row'>
            <div class='col-md-12'>
                <div class="card mb-3">

                    @include('breadcrumb', [
                        'links' => [['name' => 'Content'], ['name' => 'Blog', 'url' => route('blogpost.index')]],
                        'page_title' => trans('category.th_category'),
                        'page_title_small' => $category->name,
                    ])


                    <div class="card-body">
                        <h3>{{ trans('category.view_category_blogposts') }} ({{ $category->blogposts->count() }})</h3>

                        <div>
                            @foreach ($category->blogposts->reverse() as $blogpost)
                                <div class="col-md-4 mb-3">
                                    <a
                                        href="{{ route('blogpost.show', ['blogpost' => $blogpost]) }}">{{ $blogpost->title }}</a>
                                    @if ($blogpost->isDraft())
                                        <span class="ms-2 badge bg-info">{{ trans('actions.draft') }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
