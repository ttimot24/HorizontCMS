@extends('layout', ['title' => trans('User roles')])

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">

            @include('breadcrumb', [
                'links' => [
                    ['name' => 'Content'],
                    ['name' => trans('user.users'), 'url' => route('user.index')],
                    ['name' => 'Roles', 'url' => route('userrole.index')],
                ],
                'page_title' => 'User roles',
                'stats' => [['label' => trans('user.all'), 'value' => $all_user_roles->count()]],
                'buttons' => [
                    [
                        'label' => 'New role',
                        'route' => route('userrole.create'),
                        'class' => 'btn-warning',
                    ],
                ],
            ])


            <div class="card-body">

                <div class="row">
                    <?php foreach($all_user_roles->reverse() as $role): ?>
                    <div class='col-md-3'>
                        <form action="{{ route('userrole.update', ['userrole' => $role]) }}" method='POST'>

                            @csrf
                            @method('PUT')

                            <div class="panel panel-primary mb-4">
                                <!-- Default panel contents -->
                                <div class="panel-heading bg-primary p-3">
                                    <h4 class="text-white">
                                        {{ $role->name }} <small class="text-dark">({{ $role->users->count() }})</small>
                                        <small>
                                            
                                            @if (\Auth::user()->role->is($role))

                                                <img src="{{ \Auth::user()->getThumb() }}" class='img-rounded pull-right' style='width:15%;height:15%;' />

                                            @endif
                                            
                                        </small>
                                    </h4>

                                </div>

                                <!-- List group -->
                                <ul class="list-group">

                                    <?php
                                    
                                    foreach ($permission_list as $key => $perm_name) {
                                        if (isset($role->rights) && in_array($key, $role->rights)) {
                                            $check = 'checked';
                                        } else {
                                            $check = '';
                                        }
                                    
                                        $disable = $role->name == 'Admin' ? ' disabled' : '';
                                    
                                        $perm_name = str_replace('Admin area', "<b class='text-danger'>Admin area</b>", $perm_name);
                                    
                                        echo "<li class='list-group-item bg-dark text-white'>" . $perm_name . "<input type='checkbox' class='pull-right' name='" . $key . "' value='1' " . $check . ' ' . $disable . '></li>';
                                    }
                                    
                                    ?>

                                    <li class='list-group-item bg-dark text-white'>

                                        <div class='btn-group w-100' role='group'>

                                            <button type='submit' class='btn btn-success btn-sm w-75'
                                                {{ $disable }}>Save changes</button>

                                            <a data-bs-toggle='modal'
                                                data-bs-target='#delete_{{ $role->id }}
                                '
                                                class='btn btn-danger btn-sm w-25' {{ $disable }}><i
                                                    class='fa fa-trash-o' aria-hidden='true'></i></a>

                                        </div>

                                    </li>

                                </ul>
                            </div>


                        </form>

                        @include('confirm_delete', [
                            'route' => route('userrole.destroy', ['userrole' => $role]),
                            'id' => 'delete_' . $role->id,
                            'header' => trans('actions.are_you_sure'),
                            'name' => $role->name,
                            'content_type' => 'role',
                            'delete_text' => trans('actions.delete'),
                            'cancel' => trans('actions.cancel'),
                        ])

                    </div>
                    <?php endforeach; ?>

                </div>

            </div>

        </div>
    @endsection
