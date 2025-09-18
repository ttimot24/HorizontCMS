@extends('layout', ['title' => trans('blogpost.blogposts')])

@section('content')
    <div class='container main-container'>
        <div class="card mb-3">

            @include('breadcrumb', [
                'links' => [['name' => trans('dashboard.content')], ['name' => 'Blog', 'url' => route('blogpost.index')]],
                'page_title' => trans('blogpost.blogposts'),
                'stats' => [['label' => trans('blogpost.all'), 'value' => $all_blogposts->total()]],
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
                                <td>{{  $blogpost->id }}
                                <br><span class='badge bg-secondary'>{{ strtoupper($blogpost->language) }} </span>
                                </td>
                                <td>
                                @if($blogpost->getFeaturedMediaType()==='video')
                                    <video controls="false" width=70 height=50 >
                                        <source src="{{ $blogpost->getImage()}}">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src='{{ $blogpost->getThumb() }}' class='img img-rounded' style='object-fit:cover;' width=70 height=50 /> 
                                @endif
                                    
                                    
                                  </td>
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
                                <td class='hidden-xs text-center justify-content-center align-items-center col-1'>{{ $blogpost->created_at->format('Y-m-d') }}</br>
                                    <font size='2'><i>at</i> {{ $blogpost->created_at->format('H:i:s') }}</font>
                                </td>
                                @if ($blogpost->author)
                                    <td><a
                                            href="{{ route('user.show', ['user' => $blogpost->author]) }}">{{ $blogpost->author->username }}</a>
                                    </td>
                                @else
                                    <td>{{ trans('blogpost.removed_user') }}</td>
                                @endif
                                @if ($blogpost->categories)
                                    <td class='hidden-xs col-1'>
                                    @foreach($blogpost->categories as $category)

                                        <span class="badge bg-success {{ $blogpost->categories->count()==1? 'd-block' : '' }}" style='font-size:13px;'>{{ $category->name }}</span>
                                  
                                    @endforeach
                                    </td>
                                @else
                                    <td class='hidden-xs'>none</td>
                                @endif
                                <td class="text-center">

                                    <div class="dropdown">
                                        <div data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                                            <i class="fa-solid fa-ellipsis-vertical text-dark fs-5"></i>
                                        </div>
                                        <ul class="dropdown-menu text-dark">
                                            @can('update', 'blogpost')
                                            <li>
                                                <form method="POST"
                                                action="{{ route('blogpost.update', ['blogpost' => $blogpost]) }}">
                                                @csrf
                                                @method('PUT')
    
                                                @if($blogpost->isDraft())
                                                    <input type="hidden" name="active" value="1">
                                                    <button type="submit" class='dropdown-item text-decoration-none text-darks'>
                                                        <span class='fa fa-plus me-2' aria-hidden='true'></span>
                                                        {{ trans('Publish') }}
                                                    </button>
                                                @else
                                                    <input type="hidden" name="active" value="0">
                                                    <button type="submit" class='dropdown-item text-decoration-none text-darks'>
                                                        <span class='fa fa-minus me-2' aria-hidden='true'></span>
                                                        {{ trans('Unpublish') }}
                                                    </button>
                                                @endif
                                            </form>
                                            </li>
                                            <li>
                                                <a href="{{ route('blogpost.edit', ['blogpost' => $blogpost]) }}"
                                                    class="dropdown-item text-decoration-none text-dark">
                                                    <i class="fa fa-pencil me-2" aria-hidden="true"></i>
                                                    {{ trans('actions.edit') }}
                                                </a>
                                            </li>
                                            @endcan
                                            @can('delete', 'blogpost')
                                            <li>
                                                <a data-bs-toggle='modal' data-bs-target=#delete_<?= $blogpost->id ?>
                                                    class="dropdown-item text-danger text-decoration-none"
                                                    style="cursor: pointer;">
                                                    <i class="fa fa-trash me-2" aria-hidden="true"></i>
                                                    {{ trans('actions.delete') }}
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
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

        @can('delete', 'blogpost')
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
        @endcan

    </div>
@endsection
