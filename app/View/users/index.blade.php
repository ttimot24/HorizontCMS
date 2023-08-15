@extends('layout')

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">

                @include('breadcrumb', [
                        'links' => [['name' => 'Content'], ['name' => trans('user.users'), 'url' => route('user.index')]],
                        'page_title' => trans('user.registered_users'),
                        'stats' => [
                            ['label'=> trans('user.all'), 'value'=> $number_of_users],
                            ['label'=> trans('user.active'), 'value'=> $active_users],
                            ['label'=> trans('user.inactive'), 'value'=> $number_of_users - $active_users]
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

                                    <?php
                                    $disabled = '';
                                    if ($each->role_id >= \Auth::user()->role_id || $each->is(Auth::user())) {
                                        $disabled = 'disabled';
                                    }
                                    ?>


                                    <div class='btn-group' role='group'>
                                        <a href="{{ route('user.edit', ['user' => $each]) }}" type='button'
                                            class='btn btn-warning btn-sm {{ $disabled }}' style='min-width:70px;'
                                            {{ $disabled }}>{{ trans('actions.edit') }}</a>

                                        <a type='button' data-bs-toggle='modal'
                                            data-bs-target='#delete_{{ $each->id }}'
                                            class='btn btn-danger btn-sm {{ $disabled }}' {{ $disabled }}><i
                                                class='fa fa-trash-o' aria-hidden='true'></i></a>

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

                        @foreach ($all_users as $each)
                            @if($disabled != 'disabled')
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


        </div>
    @endsection
