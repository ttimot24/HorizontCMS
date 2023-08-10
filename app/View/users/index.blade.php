@extends('layout')

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">
            <div class="card-header fw-bold">

                <h2>{{ trans('user.registered_users') }} <small class='pull-right text-muted pt-3'>{{ trans('user.all') }}:
                        {{ $number_of_users }} | {{ trans('user.active') }}: {{ $active_users }} |
                        {{ trans('user.inactive') }}:
                        {{ $number_of_users - $active_users }}</small></h2>


                <div class='container col-md-12'><a href="{{ route('user.create') }}"
                        class='btn btn-warning mb-3'>{{ trans('user.new_user_button') }}</a></div>

            </div>

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
                                        <p class='text-success'>Online</p>
                                    @else
                                        <p class='text-danger'>Offline</p>
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
