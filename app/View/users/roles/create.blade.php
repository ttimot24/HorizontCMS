@extends('layout', ['title' => trans('Create role')])

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">

            @include('breadcrumb', [
                'links' => [['name' => 'Content'], ['name' => trans('user.users'), 'url' => route('user.index')]],
                'page_title' => 'Create User Group',
            ])

            <div class="card-body">

                <form action="{{ route('userrole.store') }}" method='POST'>

                    @csrf

                    <div class='col-12'>
                        <div class="panel panel-primary">
                            <!-- Default panel contents -->
                            <div class="panel-heading bg-primary p-3">
                                <div class="row">
                                    <div class='col-8'>
                                        <input type='text' class='col-8 form-control' name='name' required>
                                    </div>
                                    <div class="col-4">
                                        <button type='submit' class='col-4 btn btn-warning w-100'>Add user group</button>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row bg-dark">

                                    <div>
                                        <div class="row">
                                            <div class='col-4 p-4'>
                                                <h4 class="text-danger"><strong>Admin Area</strong></h4>
                                            </div>
                                            <div class="col-4 p-4 mt-2">
                                                <input type='checkbox' name="admin_area" value='1'>
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
                                                    <?php $perm_name = str_replace('Admin area', "<b style='color:red;'>Admin area</b>", $perm_name); ?>

                                                    <li class='list-group-item bg-dark text-white'>
                                                        {{ $perm_name }}<input type='checkbox' class='pull-right'
                                                            name="{{ $key . '_' . $action }}" value='1'></li>
                                                @endforeach



                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </form>


            </div>

        </div>
    @endsection
