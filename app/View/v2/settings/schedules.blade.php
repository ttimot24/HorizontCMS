@extends('layout')

@section('content')
<div class='container'>
<h1>{{trans('settings.scheduler')}} <small class='pull-right' style='margin-top:1.5%;'>All: {{$scheduled_tasks->count()}} | Available: {{count($commands)}}</small></h1>
<br>
<br>
<div class='container col-md-12'><a class='btn btn-warning' data-toggle='modal' data-target='.new_task' style='margin-bottom:20px;'>{{trans('Schedule task')}}</a></div>

<table class='table table-hover'>
    <thead>
      <tr class="bg-dark text-white">
      	<th>{{trans('schedules.th_id')}}</th>
      	<th>{{trans('schedules.th_name')}}</th>
        <th>{{trans('schedules.th_command')}}</th>
        <th>{{trans('schedules.th_arguments')}}</th>
        <th>{{trans('schedules.th_frequency')}}</th>
        <th>{{trans('schedules.th_ping_before')}}</th>
        <th>{{trans('schedules.th_ping_after')}}</th>
        <th><center>{{trans('schedules.th_action')}}</center></th>
      </tr>
    </thead>
    <tbody>
        @foreach($scheduled_tasks as $task)
        <tr>
            <td>{{$task->id}}</td>
            <td>{{$task->name}}</td>
            <td>{{$task->command}}</td>
            <td>{{$task->arguments}}</td>
            <td>{{$task->frequency}}</td>
            <td>{{$task->ping_before}}</td>
            <td>{{$task->ping_after}}</td>
            <td>
              <center>
                <div class="btn-group" role="group">
                    <a href="{{admin_link('schedules-edit',$task->id)}}" type="button" class="btn btn-warning btn-sm" style='min-width:70px;'>{{trans('actions.edit')}}</a>
                    <a type="button" data-toggle='modal' data-target=.delete_<?= $task->id ?> class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                </div>
              </center>
            </td>
        </tr>

        <?php 

            Bootstrap::delete_confirmation(
            "delete_".$task->id."",
            trans('actions.are_you_sure'),
            "<b>".trans('actions.delete_this',['content_type'=>'task']).": </b>".$task->name." <b>?</b>",
            "<a href='".admin_link('task-delete',$task->id)."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete')."</a>
            <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
            );

        ?>

        @endforeach
    </tbody>
</table>



<div class='modal new_task' id='create_file' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header modal-header-primary bg-primary'>
        <h4 class='modal-title text-white'>Schedule task</h4>
        <button type='button' class='close text-white' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
      </div>

      <form action="{{config('horizontcms.backend_prefix')}}/schedule/create" method='POST'>
      <div class='modal-body'>
      {{ csrf_field() }}

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
      <select name='command' class='form-control' style='width:100%;'>
            @foreach($commands as $key => $command)
              <option value='{{$key}}'>{{$key}}</option>
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
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



</div>
@endsection