@extends('layout')

@section('content')
    <div class='container'>
    
        <div class="card mb-3">

        @include('breadcrumb', [
            'links' => [['name' => trans('settings.settings'), 'url' => route('settings.index')]],
            'page_title' => trans('settings.scheduler'),
            'stats' => [
                ['label'=> trans('user.all'), 'value' => $scheduled_tasks->count()]
            ],
                'buttons' => [
                   [
                        'label' => trans('Schedule task'),
                        'class' => 'btn-warning',
                        'data' => 'data-bs-toggle=modal data-bs-target=.new_task'
                    ],
                ],
        ])

        <div class="card-body">

        <table class='table table-hover'>
            <thead>
                <tr class="bg-dark text-white">
                    <th>{{ trans('schedules.th_id') }}</th>
                    <th>{{ trans('schedules.th_name') }}</th>
                    <th>{{ trans('schedules.th_command') }}</th>
                    <th>{{ trans('schedules.th_arguments') }}</th>
                    <th>{{ trans('schedules.th_frequency') }}</th>
                    <th>{{ trans('schedules.th_ping_before') }}</th>
                    <th>{{ trans('schedules.th_ping_after') }}</th>
                    <th class='text-center'>{{ trans('schedules.th_action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scheduled_tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->command }}</td>
                        <td>{{ $task->arguments }}</td>
                        <td>{{ $task->frequency }}</td>
                        <td>{{ $task->ping_before }}</td>
                        <td>{{ $task->ping_after }}</td>
                        <td class='text-center'>
                            <div class="btn-group" role="group">
                                <a href="{{ route('schedule.update', ['schedule' => $task]) }}" type="button"
                                    class="btn btn-warning btn-sm">{{ trans('actions.edit') }}</a>
                                <a type="button" data-bs-toggle='modal' data-bs-target=#delete_<?= $task->id ?>
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>

                    @include('confirm_delete', [
                        'route' => route('schedule.destroy', ['schedule' => $task]),
                        'id' => 'delete_' . $task->id,
                        'header' => trans('actions.are_you_sure'),
                        'name' => $task->name,
                        'content_type' => 'task',
                        'delete_text' => trans('actions.delete'),
                        'cancel' => trans('actions.cancel'),
                    ])
                @endforeach
            </tbody>
        </table>



        <div class='modal new_task' id='create_file' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
            aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header modal-header-primary bg-primary'>
                        <h4 class='modal-title text-white'>Schedule task</h4>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>

                    <form action="{{ route('schedule.store') }}" method='POST'>
                        <div class='modal-body'>
                            @csrf

                            <div class='form-group'>
                                <label for='name'>Name:</label>
                                <input type='text' class='form-control' id='name' name='name'>
                            </div>

                            <div class='form-group'>
                                <label for='frequency'>Cron:</label>
                                <input type='text' class='form-control' id='cron' name='frequency'>
                            </div>

                            <div class='form-group'>
                                <label for='command'>Command:</label>
                                <select name='command' class='form-select'>
                                    @foreach ($commands as $key => $command)
                                        <option value='{{ $key }}'>{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class='form-group'>
                                <label for='ping_before'>Arguments:</label>
                                <input type='text' class='form-control' id='arguments' name='arguments'>
                            </div>

                            <div class='form-group'>
                                <label for='ping_before'>Ping before:</label>
                                <input type='text' class='form-control' id='ping_before' name='ping_before'>
                            </div>

                            <div class='form-group'>
                                <label for='ping_after'>Ping after:</label>
                                <input type='text' class='form-control' id='ping_after' name='ping_after'>
                            </div>


                        </div>
                        <div class='modal-footer'>
                            <button type='submit' class='btn btn-primary'>Schedule</button>
                            <button type='button' class='btn btn-default' data-bs-dismiss='modal'>Cancel</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        </div>
        </div>
    </div>
@endsection
