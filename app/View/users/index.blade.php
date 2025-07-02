@extends('layout', ['title' => trans('user.users')])

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">

                @include('breadcrumb', [
                        'links' => [['name' => 'Content'], ['name' => trans('user.users'), 'url' => route('user.index')]],
                        'page_title' => trans('user.registered_users'),
                        'stats' => [
                            ['label'=> trans('user.all'), 'value'=> $all_users->total()],
                            ['label'=> trans('user.active'), 'value'=> $active_users],
                            ['label'=> trans('user.inactive'), 'value'=> $all_users->total() - $active_users]
                        ],
                        'buttons' => [
                            [
                                'label' => trans('user.new_user_button'),
                                'route' => route('user.create'),
                                'class' => 'btn-warning'
                            ]
                        ]
                    ])

            <div class="card-body">

                <table class='table table-hover'>
                    <thead>
                        <tr class="bg-dark text-white">
                            <th>{{ trans('user.th_id') }}</th>
                            <th>{{ trans('user.th_image') }}</th>
                            <th>{{ trans('user.th_name') }}</th>
                            <th>{{ trans('user.th_username') }}</th>
                            <th>{{ trans('user.th_email') }}</th>
                            <th class="text-center">{{ trans('user.th_rank') }}</th>
                            <th class="text-center">{{ trans('user.th_session') }}</th>
                            <th class="text-center">{{ trans('actions.th_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($all_users as $each)
                            <tr>

                                <td>{{ $each->id }}</td>

                                <td>
                                    <img src="{{ $each->getImage() }}" class='img-rounded' style='object-fit:cover;'
                                        width='50' height='50' />
                                </td>

                                <td><a href='{{ route('user.show', ['user' => $each]) }}'>{{ $each->name }}</a></td>

                                <td>{{ $each->username }}</td>

                                <td>{{ $each->email }} <br> @if(!$each->isActive()) <span class="badge rounded-pill w-75 text-bg-danger">{{ trans('user.inactive') }}</span> @endif</td>

                                <td>
                                    <span
                                        class="d-block badge rounded-pill {{ $each->isAdmin()? 'bg-danger' : 'bg-dark' }}"
                                        style='font-size:13px;'>
                                        @if($each->role)
                                            {{ $each->role->name }}
                                        @else
                                            Unassigned
                                        @endif
                                    </span>
                                </td>

                                <td class="text-center text-bold">

                                    @if ($each->isOnline())
                                        <span class='badge rounded-pill bg-success w-75'>Online</span>
                                    @else
                                        <span class='badge rounded-pill bg-danger w-75'>Offline</span>
                                    @endif

                                </td>
                                <td class='text-center'>

                                    <div class="dropdown">
                                        <div data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">
                                            <i class="bi bi-three-dots-vertical text-dark"></i>
                                        </div>
                                        <ul class="dropdown-menu text-dark">
                                            @can('update', 'user')
                                            <li>
                                                <a href="{{ route('user.edit', ['user' => $each]) }}"
                                                    class="dropdown-item text-decoration-none text-dark">
                                                    <i class="fa fa-pencil me-2" aria-hidden="true"></i>
                                                    {{ trans('actions.edit') }}
                                                </a>
                                            </li>
                                            @endcan
                                            @can('delete', 'user')
                                            @if ($each->role_id <= \Auth::user()->role_id && !$each->is(Auth::user()))
                                            <li>
                                                <a data-bs-toggle='modal' data-bs-target=#delete_<?= $each->id ?>
                                                    class="dropdown-item text-danger text-decoration-none"
                                                    style="cursor: pointer;">
                                                    <i class="fa fa-trash-o me-2" aria-hidden="true"></i>
                                                    {{ trans('actions.delete') }}
                                                </a>
                                            </li>
                                            @endif
                                            @endcan
                                        </ul>
                                    </div>

                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $all_users->links() }}
                </div>

            </div>
            @can('delete', 'user')
                        @foreach ($all_users as $each)
                            @if($each->role_id <= \Auth::user()->role_id && !$each->is(Auth::user()))
                                @include('confirm_delete', [
                                    'route' => route('user.destroy', ['user' => $each]),
                                    'id' => 'delete_' . $each->id,
                                    'header' => trans('actions.are_you_sure'),
                                    'name' => $each->username,
                                    'content_type' => 'user',
                                    'delete_text' => trans('actions.delete'),
                                    'cancel' => trans('actions.cancel'),
                                ])
                            @endif
                        @endforeach
            @endcan

        </div>
    </div>
    @endsection
