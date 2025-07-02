<div class="card mt-3">
    <div class="card-header">
        <div class="row my-2">
            <h2 class="col">{{ trans('comment.moderator') }}</h2>
            @if ($blogpost->comments_enabled == 1)
                <div class="col">
                    <div class="row">

                        @can('create', 'blogpostcomment')
                        <div class="col d-flex justify-content-end">
                            <a class='btn btn-warning' data-bs-toggle='modal'
                                data-bs-target='#comment-modal-xl'>{{ trans('comment.write_comment_button') }}</a>
                        </div>
                        @endcan

                        <div class="col">
                            @can('update', 'blogpost')
                            <form method="POST" action="{{ route('blogpost.update', ['blogpost' => $blogpost]) }}">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="comments_enabled" value="0">
                                <button type="submit"
                                    class='btn btn-danger btn-sm mt-1'>{{ trans('comment.disable_comments_button') }}</button>

                            </form>
                            @endcan
                        </div>
                    </div>

                </div>
            @endif
            <div class='col text-muted pt-2 text-end fs-5'>{{ trans('comment.all_comments') }}:
                {{ $blogpost->comments->count() }}</div>
        </div>
    </div>
    <div class="card-body">
        @if ($blogpost->comments_enabled != 1)
            <div class="alert alert-warning" role="alert">
                <div class="row">
                    <div class="col-9">{!! trans('comment.comments_not_enabled') !!}</div>
                    <div class="col-3 text-end">
                        <form method="POST" action="{{ route('blogpost.update', ['blogpost' => $blogpost]) }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="comments_enabled" value="1">
                            <button type="submit"
                                class='btn btn-info btn-sm mt-1'>{{ trans('comment.enable_comments_button') }}</button>

                        </form>
                    </div>
                </div>
            </div>
        @else
            <table class='table table-hover'>
                <thead>
                    <tr class="bg-dark text-white">
                        <!--<th>Id</th>-->
                        <th class="col">{{ trans('comment.th_image') }}</th>
                        <th class="col">{{ trans('comment.th_name') }}</th>
                        <th class="col">{{ trans('comment.th_comment') }}</th>
                        <th class="col">{{ trans('comment.th_date') }}</th>
                        <th class="col text-center">{{ trans('actions.th_action') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($blogpost->comments->reverse() as $comment)
                        <tr>
                            <td class='col'><img class='img-rounded' src='{{ $comment->user->getThumb() }}'
                                    width='70'>
                            </td>
                            <td class='col'><a
                                    href="{{ route('user.show', ['user' => $comment->user]) }}">{{ $comment->user->username }}</a>
                            </td>
                            <td class='col' style='text-align:justify;'>{{ $comment->comment }}</td>
                            <td>{{ $comment->created_at->format('Y.m.d') }} </br>
                                <font size='2'><i>at {{ $comment->created_at->format('H:i:s') }}</i></font>
                            </td>

                            <td class="text-center">


                                <div class="dropdown">
                                    <div data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                                        <i class="bi bi-three-dots-vertical text-dark"></i>
                                    </div>
                                    <ul class="dropdown-menu text-dark">
                                        <li>
                                            <a data-bs-toggle='modal' data-bs-target=#delete_<?= $comment->id ?>
                                                class="dropdown-item text-danger text-decoration-none"
                                                style="cursor: pointer;">
                                                <i class="fa fa-trash-o me-2" aria-hidden="true"></i>
                                                {{ trans('actions.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>

                        @include('confirm_delete', [
                            'route' => route('blogpostcomment.destroy', ['blogpostcomment' => $comment]),
                            'id' => 'delete_' . $comment->id,
                            'header' => trans('actions.are_you_sure'),
                            'name' => $comment->user->username . " said: \"" . $comment->comment . "\"",
                            'content_type' => 'comment',
                            'delete_text' => trans('actions.delete'),
                            'cancel' => trans('actions.cancel'),
                        ])
                    @endforeach

                </tbody>
            </table>

            <div class='modal' id='comment-modal-xl' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel'
                aria-hidden='true'>
                <div class='modal-dialog modal-md'>
                    <div class='modal-content'>
                        <div class='modal-header-warning bg-warning text-white p-2'>
                            <button type='button' class='btn-close col-md-6 float-end' data-bs-dismiss='modal'
                                aria-label='Close'></button>
                            <h4 class='modal-title col-md-6'><span class='fa fa-comment-o'></span>
                                {{ trans('comment.write_comment_button') }}</h4>
                        </div>

                        <form action="{{ route('blogpostcomment.store') }}" method='POST'>
                            @csrf
                            <div class='modal-body'>
                                <h5 style='font-weight:bolder;'>{{ trans('comment.write_as') }}: <a
                                        href="{{ route('user.show', ['user' => $user]) }}">{{ $user->username }}</a>
                                    <img src='{{ $user->getThumb() }}' class='img img-rounded pull-right'
                                        width='30'>
                                </h5>
                                <input type='hidden' name='blogpost_id' value='{{ $blogpost->id }}'>
                                <textarea style='width:100%;' rows='5' name='comment' required></textarea>
                            </div>
                            <div class='modal-footer'>
                                <button type='submit' class='btn btn-warning'>{{ trans('comment.send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
