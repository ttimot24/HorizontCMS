@extends('layout')

@section('content')

<div class='container main-container'>

  <h2 class="mb-5">{{ trans('settings.adminarea_settings') }}</h2>


  <form action='{{route("settings.store")}}' role='form' method='POST'>
  @csrf

  <input type='hidden' name='is_actioned' value='1'>
  <table class='table-bordered w-100' id='settings'>

  <tbody class="text-center fw-bold">


  <tr>
    <td>{{ trans('settings.adminarea_theme') }}</td>
    <td>
      <select name='admin_theme' class='form-select' disabled>
        <option value=''>default</option>
      </select>
    </td>
  </tr>

  <tr><td>{{ trans('settings.adminarea_dashboard_logo') }}</td><td class="p-3">
  <div class="col-12 mb-3">
    <input type="hidden" name="admin_logo" value="<?= ($settings['admin_logo']!='' && file_exists('storage/images/logos/'.$settings['admin_logo']))? $settings['admin_logo'] : \Config::get('horizontcms.admin_logo')  ?>" >
    <img id="admin_logo" class='well well-sm' src="<?= ($settings['admin_logo']!='' && file_exists('storage/images/logos/'.$settings['admin_logo']))? 'storage/images/logos/'.$settings['admin_logo'] : \Config::get('horizontcms.admin_logo')  ?>" height='100'>
  </div>
  <div class="btn-group" role="group">
  <button type='button' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='.admin_logo_select-modal-lg'>{{trans('actions.select')}}</button>
  </div>

  </td></tr>

  <tr><td>{{ trans('settings.adminarea_language') }}</td><td><select name='language' class='form-select'>

              


                  @foreach($languages as $key => $language)

                    @if($key == $settings['language'])
                      <option value='{{$key}}' selected>{{ucfirst($language)}}</option>
                    @else
                      <option value='{{$key}}'>{{ucfirst($language)}}</option>
                    @endif

                  @endforeach


    
              </select>
          </td></tr>

  <tr><td>{{ trans('settings.adminarea_date_format') }}</td><td><select name='date_format' class='form-select'>

              


  @foreach($dateFormats as $format)

    @if($format == $settings['date_format'])
      <option value='{{$format}}' selected>{{date($format)}}</option>
    @else
      <option value='{{$format}}'>{{date($format)}}</option>
    @endif

  @endforeach



  </select>
  </td></tr>



  <input type="hidden" name="auto_upgrade_check" value="0"> <!-- Checkbox hack -->
  <tr><td>{{ trans('settings.adminarea_auto_update_check') }}</td>
  <td>
    <div class="form-check form-switch d-flex justify-content-center">
      <input type='checkbox' class='form-check-input' name='auto_upgrade_check' value='1' @if( $settings['auto_upgrade_check']==1 ) checked @endif >
    </div>
  </td>



  <tr>
  <td>{{ trans('settings.adminarea_broadcast_message') }}</td>
  <td>
      <textarea type='text' class='form-control' name='admin_broadcast' rows='2' >{{$settings['admin_broadcast']}}</textarea>
  </td>
  </tr>

  <tr><td></td><td class="p-2"><button type='submit' class='btn btn-primary'><span class='fa fa-floppy-o' aria-hidden='true'></span> {{ trans('settings.adminarea_save_settings') }}</button> </td></tr>

  </tbody></table>
  </form>



  <div class='modal admin_logo_select-modal-lg' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
      <div class='modal-content'>

          <div class='modal-header'>
            <h3 class='modal-title'>{{ trans('settings.adminarea_select_logo') }}</h3>

            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
          </div>
          <div class='modal-body'>
          
            @include('media.filemanager', ['mode' => '', 'current_dir' => 'storage/images/logos'])

          </div>
      </div>
    </div>
  </div>



</div>

<script>
  $("#workspace").on('click',".file",function(event) {
      var src = $(event.target).attr('src');
      var bname = filemanager.basename(src)+"."+filemanager.getFileExtension(src);
      $('[name="admin_logo"]').val(bname);
      $('#admin_logo').attr('src', 'storage/images/logos/'+bname);
      $('.admin_logo_select-modal-lg').modal("hide");
  });
</script>

@endsection