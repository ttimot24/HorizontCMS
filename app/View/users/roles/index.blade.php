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
                    @foreach($all_user_roles->reverse() as $role)

                    @php
                        $disable = $role->name == 'Admin' ? ' disabled' : '';
                    @endphp

                    <div class='col-12'>
                        <form action="{{ route('userrole.update', ['userrole' => $role]) }}" method='POST'>

                            @csrf
                            @method('PUT')

                            <div class="panel panel-primary mb-4">
                                <!-- Default panel contents -->
                                <div class="panel-heading bg-primary p-3">
                                    <h4 class="text-white">
                                        {{ $role->name }} <small class="text-dark">({{ $role->users->count() }})</small>

                                        
                                        <div class="pull-right" >
                                            
                                            @if (\Auth::user()->role->is($role))

                                                <img src="{{ \Auth::user()->getThumb() }}" style='width:3rem;height:3rem;margin-top:-.5rem;'  />

                                            @endif
                                        </div>
                                    </h4>

                                </div>


                            <div class="container">
                                <div class="row bg-dark">


                                <div class="bg-dark">
                                    <div class="row">
                                        <div class='col-4 p-4'>
                                            <h4 class="text-danger"><strong>Admin Area</strong></h4>
                                        </div>
                                        <div class="col-4 p-4 mt-2">
                                            <input type='checkbox' name="admin_area" value='1'  {{ (isset($role->rights) && in_array('admin_area', $role->rights))? 'checked' : ''}}>
                                        </div>
                                    </div>
                                </div>

                                           <hr class="bg-white text-white">

                                @foreach (['view', 'create', 'update', 'delete'] as $action)

                                <div class="col-3 m-0 mb-5">
                                    <h3 class="bg-dark text-white mb-0 p-3">{{ ucfirst($action) }}</h3>

                                <!-- List group -->
                                <ul class="list-group">
                    
                                    
                                    @foreach ($permission_list as $key => $perm_name)
                                    @php
                                        $check = (isset($role->rights) && in_array($key.'.'.$action, $role->rights))? 'checked' : '';
                                    
                                        $disable = $role->name == 'Admin' ? ' disabled' : '';
                                    
                                    @endphp
                                        
                                        <li class='list-group-item bg-dark text-white'>{!! $perm_name !!} <input type='checkbox' class='pull-right' name='{{ $key }}_{{ $action }}' value='1' {{ $check }} {{ $disable }}></li>
                                    @endforeach
                            

                                </ul>

                            </div>
                     
                                @endforeach
                                <div class='btn-group w-100 mb-3' role='group'>

                                    @can('update', 'userrole')
                                    <button type='submit' class='btn btn-success btn-sm w-75'
                                        {{ $disable }}>Save changes</button>
                                    @endcan

                                    @can('delete', 'userrole')
                                    <a data-bs-toggle='modal' data-bs-target='#delete_{{ $role->id }}' class='btn btn-danger btn-sm w-25' {{ $disable }}><i class='fa fa-trash-o' aria-hidden='true'></i></a>
                                    @endcan
                                </div>
                            </div>
                            
                            </div>
                            </div>


                        </form>
                        @can('delete', 'userrole')
                        @include('confirm_delete', [
                            'route' => route('userrole.destroy', ['userrole' => $role]),
                            'id' => 'delete_' . $role->id,
                            'header' => trans('actions.are_you_sure'),
                            'name' => $role->name,
                            'content_type' => 'role',
                            'delete_text' => trans('actions.delete'),
                            'cancel' => trans('actions.cancel'),
                        ])
                        @endcan

                    </div>
                    @endforeach

                </div>

            </div>

        </div>
    @endsection
