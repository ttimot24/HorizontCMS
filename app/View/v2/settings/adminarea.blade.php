@extends('layout')

@section('content')

<div class='container main-container'>

<h1>AdminArea settings</h1><br><br>


<form action='{{admin_link("settings-save")}}' role='form' method='POST'>
{{ csrf_field() }}

<input type='hidden' name='is_actioned' value='1'>
<table class='table-bordered' id='settings' style='width:100%;text-align:center;'>

<tbody style='text-align:center;font-weight:bolder;'>


<tr><td>Admin theme</td><td><select name='admin_theme' class='form-control' style='width:100%;'>
                                        <option value=''>default</option>
                                        <!--<option value='lightthm'>Light</option>-->
                                        <option value='darktheme'>Dark</option>
                                    </select></td></tr>

<tr><td>Dashboard Logo</td><td>
<br>

<input type="hidden" name="admin_logo" value="<?= ($settings['admin_logo']!='' && file_exists('storage/images/logos/'.$settings['admin_logo']))? $settings['admin_logo'] : \Config::get('horizontcms.admin_logo')  ?>" >
<img id="admin_logo" class='well well-sm' src="<?= ($settings['admin_logo']!='' && file_exists('storage/images/logos/'.$settings['admin_logo']))? 'storage/images/logos/'.$settings['admin_logo'] : \Config::get('horizontcms.admin_logo')  ?>" height='100'>

<div class="btn-group" role="group">
<button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='.admin_logo_select-modal-lg'>Select</button>
</div>

</td></tr>

<tr><td>Language</td><td><select name='language' class='form-control' style='width:100%;'>

            


                @foreach($languages as $key => $language)

                  @if($key == $settings['language'])
                    <option value='{{$key}}' selected>{{ucfirst($language)}}</option>
                  @else
                    <option value='{{$key}}'>{{ucfirst($language)}}</option>
                  @endif

                @endforeach


  
						</select>
				</td></tr>

<tr><td>Date format</td><td><select name='date_format' class='form-control' style='width:100%;'>

            


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
<tr><td>Automatically check for updates</td><td><input class='form-control' type='checkbox' name="auto_upgrade_check" value="1"  <?php if($settings['auto_upgrade_check']==1){ echo 'checked'; } ?> /></td>


<tr>
<td>Broadcast message</td>
<td>
    <textarea type='text' class='form-control' name='admin_broadcast' rows='2' >{{$settings['admin_broadcast']}}</textarea>
</td>
</tr>

<tr><td></td><td></br><button type='submit' class='btn btn-primary'><span class='fa fa-floppy-o' aria-hidden='true'></span> Save settings</button> </td></tr>

</tbody></table>
</form>



<div class='modal admin_logo_select-modal-lg' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-xl'>
    <div class='modal-content'>

        <div class='modal-header'>
          <h3 class='modal-title'><center>Select Logo</center></h3>

          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
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