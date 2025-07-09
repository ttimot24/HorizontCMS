@extends('layout', ['title' => trans('category.category')])

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
                        

                        @can('view', 'blogpost')
                        <div>
                            <div class='container'>
                                <h3>{{ trans('category.view_category_blogposts') }} ({{ $category->blogposts->count() }})</h3>
                                <table class='table table-hover'>
                                    <thead class="bg-dark text-white">
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Created At</th>
                                    </thead>
                                    <tbody>
                                @foreach ($category->blogposts->reverse() as $each)
                                <tr>
                                    <td>{{ $each->id }}</td>
                                    <td><a href="{{ route('blogpost.show', ['blogpost' => $each]) }}">{{ $each->title }}</a></td>
                                    <td>{{ $each->created_at }}</td>
                                </tr>
                                @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @endsection
