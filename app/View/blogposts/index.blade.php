@extends('layout')

@section('content')
    <div class='container main-container'>
        <div class="card mb-3">

            @include('breadcrumb', [
                'links' => [['name' => 'Content'], ['name' => 'Blog', 'url' => route('blogpost.index')]],
                'page_title' => trans('blogpost.blogposts'),
                'stats' => [['label' => trans('blogpost.all'), 'value' => $all_blogposts->count()]],
                'buttons' => [
                    [
                        'label' => trans('blogpost.new_post_button'),
                        'route' => route('blogpost.create'),
                        'class' => 'btn-primary',
                    ],
                ],
            ])


            <div class="card-body">

                <table class='table table-hover'>
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>{{ trans('blogpost.th_id') }}</th>
                            <th>{{ trans('blogpost.th_image') }}</th>
                            <th class="col-6">{{ trans('blogpost.th_title') }}</th>
                            <th>{{ trans('blogpost.th_comments') }}</th>
                            <th class='hidden-xs text-center'>{{ trans('blogpost.th_date') }}</th>
                            <th class="">{{ trans('blogpost.th_author') }}</th>
                            <th class='hidden-xs '>{{ trans('blogpost.th_category') }}</th>
                            <th class="text-center">{{ trans('actions.th_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>



                        @foreach ($all_blogposts as $blogpost)
                            <tr>
                                <td><?= $blogpost->id ?></td>
                                <td><img src='{{ $blogpost->getThumb() }}' class='img img-rounded' style='object-fit:cover;'
                                        width=70 height=50 /> </td>
                                <td><a
                                        href="{{ route('blogpost.show', ['blogpost' => $blogpost]) }}">{{ $blogpost->title }}</a><br>
                                    @if ($blogpost->isDraft())
                                        <span class="badge bg-info">{{ trans('actions.draft') }}</span>
                                    @elseif($blogpost->isFeatured())
                                        <span class="badge bg-success">{{ trans('Featured') }}</span>
                                    @endif
                                </td>
                                <td class="text-center"><span
                                        class="badge rounded-pill bg-dark">{{ count($blogpost->comments) }}</span></td>
                                <td class='hidden-xs text-center col-1'><?= $blogpost->created_at->format('Y-m-d') ?></br>
                                    <font size='2'><i>at</i> <?= $blogpost->created_at->format('H:i:s') ?></font>
                                </td>
                                @if ($blogpost->author)
                                    <td><a
                                            href="{{ route('user.show', ['user' => $blogpost->author]) }}">{{ $blogpost->author->username }}</a>
                                    </td>
                                @else
                                    <td>{{ trans('blogpost.removed_user') }}</td>
                                @endif
                                @if ($blogpost->category)
                                    <td class='hidden-xs'><span class="badge bg-success d-block"
                                            style='font-size:13px;'>{{ $blogpost->category->name }}</span></td>
                                @else
                                    <td class='hidden-xs'>none</td>
                                @endif
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('blogpost.edit', ['blogpost' => $blogpost]) }}" type="button"
                                            class="btn btn-warning btn-sm"
                                            style='min-width:70px;'>{{ trans('actions.edit') }}</a>
                                        <a type="button" data-bs-toggle='modal' data-bs-target=#delete_<?= $blogpost->id ?>
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash-o"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $all_blogposts->links() }}
                </div>

            </div>

            @foreach ($all_blogposts as $blogpost)
                @include('confirm_delete', [
                    'route' => route('blogpost.destroy', ['blogpost' => $blogpost]),
                    'id' => 'delete_' . $blogpost->id,
                    'header' => trans('actions.are_you_sure'),
                    'name' => $blogpost->title,
                    'content_type' => 'post',
                    'delete_text' => trans('actions.delete'),
                    'cancel' => trans('actions.cancel'),
                ])
            @endforeach

        </div>
    @endsection
