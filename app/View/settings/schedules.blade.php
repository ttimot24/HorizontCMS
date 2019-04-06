@extends('layout')

@section('content')
<div class='container'>
<h1>{{trans('settings.scheduler')}} <small class='pull-right' style='margin-top:1.5%;'>All: {{$scheduled_tasks->count()}} | Available: {{count($commands)}}</small></h1>
<br>
<br>
<div class='container col-md-12'><a class='btn btn-warning' style='margin-bottom:20px;'>{{trans('Schedule task')}}</a></div>

<table class='table table-hover'>
    <thead>
      <tr>
      	<th>{{trans('schedules.th_id')}}</th>
      	<th>{{trans('schedules.th_name')}}</th>
        <th>{{trans('schedules.th_command')}}</th>
        <th>{{trans('schedules.th_frequency')}}</th>
        <th>{{trans('schedules.th_ping_before')}}</th>
        <th>{{trans('schedules.th_ping_after')}}</th>
        <th><center>{{trans('schedules.th_action')}}</center></th>
      </tr>
    </thead><tbody>
        @foreach($scheduled_tasks as $task)
        <tr><td>{{$task->id}}</td><td>{{$task->name}}</td><td>{{$task->command}}</td><td>{{$task->frequency}}</td><td>{{$task->ping_before}}</td><td>{{$task->ping_after}}</td><td>
        </td></tr>
        @endforeach
    </tbody>
</table>


    @foreach($commands as $key => $command)
<!--        {{$key}}<br>
        {{get_class($command)}}<br>-->
    @endforeach

</div>
@endsection