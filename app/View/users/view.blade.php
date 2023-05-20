@extends('layout')

@section('content')
    <div class='container main-container'>


        <div class="card mb-3">
            <div class="card-header fw-bold">

        <section class='row'>

            <div class='col-9'>
                <h2>{{ trans('user.view_user') }}</h2>
            </div>

            <div class='col-3'>
                <nav id="arrows" class='pt-4'>
                    <ul class='pager list-unstyled'>


                        @if ($previous_user)
                            <li class='previous float-start'><a class="rounded-pill bg-dark px-3 py-2 text-white"
                                    href="{{ route('user.show', ['user' => $previous_user]) }}"> <i class="fa fa-angle-left" aria-hidden="true"></i>

                                    {{ trans('actions.previous') }}</a></li>
                        @endif

                        @if ($next_user)
                            <li class='next float-end'><a class="rounded-pill bg-dark px-3 py-2 text-white"
                                    href="{{ route('user.show', ['user' => $next_user]) }}">{{ trans('actions.next') }} <i class="fa fa-angle-right" aria-hidden="true"></i>
 </a></li>
                        @endif

                    </ul>
                </nav>
            </div>
        </section>

        </div>

        <div class="card-body">



        <section class='row'>
            <div class='col-md-3 text-center' valign='top'>
                <a class='btn btn-link' data-bs-toggle='modal' data-bs-target='#modal-xl-{{ $user->id }}'>
                    <img src='{{ $user->getImage() }}' class='img img-thumbnail mt-3'>
                </a>

                <div class='btn-group my-3' role='group'>
                    <a href='#' type='button' class='btn btn-warning mx-1'><span class='fa fa-star'
                            aria-hidden='true'></span> {{ trans('actions.deactivate') }}</a>
                    <a href="{{ route('user.edit', ['user' => $user]) }}" type='button' class='btn btn-warning'><span
                            class='fa fa-pencil' aria-hidden='true'></span> {{ trans('actions.edit') }}</a>
                </div>
                @if ($user->role_id < \Auth::user()->role_id && !$user->is(Auth::user()))
                    <button type='button' class='btn btn-danger my-3' data-bs-toggle='modal'
                        data-bs-target='#delete_{{ $user->id }}'>
                        <span class='fa fa-trash' aria-hidden='true'></span> {{ trans('actions.remove') }}
                    </button>
                @endif

                <b class="d-block text-center mb-3">{{ trans('user.view_full_name') }} : <a
                        class="color-primary">{{ $user->name }}</a></b>
                <b class="d-block text-center mb-3">{{ trans('user.view_user_name') }} : <a
                        class="color-primary">{{ $user->username }}</a></b>
                <b class="d-block text-center mb-3">{{ trans('user.view_rank') }} : <a>{{ $user->role->name }}</a></b>
                <b class="d-block text-center mb-3">{{ trans('user.view_email') }} : <a
                        class="color-primary">{{ $user->email }}</a></b>
                <b class="d-block text-center mb-3">{{ trans('user.view_phone') }} : <a
                        class="color-primary">{{ $user->phone }}</a></b>
                <b class="d-block text-center mb-3">{{ trans('user.view_registered_on') }} : </br><a
                        class="color-primary">{{ $user->created_at->format(\Settings::get('date_format', \Config::get('horizontcms.default_date_format'), true)) }}</a></b>
                <b class="d-block text-center mb-3">{{ trans('user.view_logins') }} : <a
                        class="color-primary">{{ $user->visits }}</a></b>
                <hr />
            </div>

            <div valign='top' class='col-md-9'>

                <?php
                
                if (!$user->isActive()) {
                    echo "<div class='card mt-4'>
                            <div class='card-header bg-danger'>
                              <h4 class='card-title mt-2 mb-2 pt-0 pb-0'><b>Inactive user</b></h4>
                            </div>
                              <div class='card-body' style='text-align:center;'><font size='4'>
                              " .
                        trans('user.inactive_about', ['day_count' => $user->created_at->diffForHumans()]) .
                        "
                              </font> <a href='admin/user/activate/" .
                        $user->id .
                        "' class='btn btn-sm btn-danger pull-right'>Force activate</a>
                              </div>
                          </div>";
                }
                
                if ($user->isAdmin()) {
                    echo '<h2>' . trans('blogpost.blogposts') . '(' . $user->blogposts->count() . ')</h2>';
                
                    echo "<table class='table table-condensed table-hover'>
                    <thead>
                      <tr class='d-flex bg-dark text-white'>
                        <th class='col-4'>Image</th>
                        <th class='col-6'>Title</th>
                        <th class='col-2'>Date</th>
                      </tr>
                    </thead>
                    <tbody>";
                
                    foreach ($user->blogposts->reverse() as $each) {
                        echo "<tr class='d-flex'>";
                        echo "<td class='col-4'><a href='" . route('blogpost.show', ['blogpost' => $each]) . "'>";
                        echo Html::img($each->getThumb(), "class='img img-thumbnail bg-dark', width='250' style='object-fit:cover;height:150px;'");
                        echo '</a></td>';
                        echo "<td class='col-6'>
                            <a href='" .
                            route('blogpost.show', ['blogpost' => $each]) .
                            "'><h5>" .
                            $each->title .
                            "</h5></a>
                            <p>" .
                            $each->summary .
                            "</p>
                         </td>";
                
                        echo "<td class='col-2 text-right'>" . $each->created_at->format('Y.m.d') . "</br><font size='2'><i>at</i> " . $each->created_at->format('H:i:s') . '</font></td>';
                        echo '</tr>';
                    }
                
                    echo '</tbody></table>';
                
                    echo '</div></section>';
                
                    echo '</br></br>';
                }
                
                ?>


                @include('image_details', ['modal_id' => $user->id, 'image' => $user->getImage()])


                @include('confirm_delete', [
                    'route' => route('user.destroy', ['user' => $user]),
                    'id' => 'delete_' . $user->id,
                    'header' => trans('actions.are_you_sure'),
                    'name' => $user->username,
                    'content_type' => 'user',
                    'delete_text' => trans('actions.delete'),
                    'cancel' => trans('actions.cancel'),
                ])




                <h2>{{ trans('blogpost.comments') }} ({{ $user->comments->count() }})</h2>

                <table class='table table-condensed table-hover'>
                    <thead>
                        <tr class="d-flex bg-dark text-white">
                            <th class="col-3">{{ trans('blogpost.post') }}</th>
                            <th class="col-8">{{ trans('blogpost.th_comment') }}</th>
                            <th class="col-1">{{ trans('blogpost.th_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        
                        foreach ($user->comments as $each) {
                            if ($each->blogpost != null) {
                                echo "<tr class='d-flex'>";
                                echo "<td class='col-3'><a href='" . route('blogpost.show', ['blogpost' => $each->blogpost]) . "'>" . $each->blogpost->title . '</a></td>';
                                echo "<td class='col-8' style='text-align:justify;'>" . $each->comment . '</td>';
                        
                                echo "<td class='col-1'>" . $each->created_at->format('Y.m.d') . "</br><font size='2'><i>at</i> " . $each->created_at->format('H:i:s') . '</font></td>';
                                echo '</tr>';
                            }
                        }
                        
                        ?>

                    </tbody>
                </table>

            </div>

    </div>
    </section>

    </div>
@endsection
