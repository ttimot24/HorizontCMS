@extends('layout')
@section('content')
<div class='container main-container'>
<h2>Website settings</h2>
<br><br>
<form action='{{route("settings.store")}}' role='form' method='POST'>
  @csrf
   <table class='table-bordered col-md-12 text-center' id='settings'>
      <tbody class="font-weight-bold">
         <tr>
            <td class='col-5 p-2'>Title</td>
            <td class="col-8 p-0"><input type='text' class='form-control' name='title' value="{{$settings['title']}}" placeholder="What you write here, will be the name of the browser page."></td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Site name</td>
            <td class="col-8 p-0"><input type='text' class='form-control' name='site_name' value="{{$settings['site_name']}}"></td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Slogan</td>
            <td class="col-8 p-0"><input type='text' class='form-control' name='slogan' value="{{$settings['slogan']}}"></td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Warning text</td>
            <td class="col-8 p-0"><input type='text' class='form-control' name='scroll_text' value="{{$settings['scroll_text']}}"></td>
         </tr>
         <tr>
            <td class='col-4 p-4'>Favicon</td>
            <td class="col-8 p-3">
               <?php 
                  $favicon = null;
                  if(($settings['favicon'] != '' && file_exists('storage/images/favicons/' . $settings['favicon']))){
                     $favicon = $settings['favicon'];
                  }
               ?>
               <div class="col-12 mb-3">
                  <input type="hidden" name="favicon" value="<?= $favicon ?>" >
                  <img id="favicon" src="storage/images/favicons/<?= $favicon ?>" style="max-height:2.5rem;" alt="Select an image">
               </div>
                <div class="btn-group" role="group">
                  <button type='button' id="button-favicon" class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#filemanager-modal'>{{ trans('actions.select') }}</button>
               </div>
            </td>
         </tr>
         <tr>
            <td class='col-4 p-4'>Debug mode</td>
            <td class="col-8 p-0">
               <div class="form-check form-switch d-flex justify-content-center">
                  <input type='checkbox' class='form-check-input' name='website_debug' value='1' <?php if ($settings['website_debug'] == 1) {echo 'checked';}?> >
               </div>
            </td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Email</td>
            <td class="col-8 p-0"><input type='email' class='form-control' name='default_email' value="{{$settings['default_email']}}"></td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Phone</td>
            <td class="col-8 p-0"><input type='text' class='form-control' name='default_phone' value="{{$settings['default_phone']}}"></td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Contact info</td>
            <td class="col-8 p-0"><textarea rows='7' class='form-control' name='contact' cols='30'>{{ $settings['contact'] }}</textarea></td>
         </tr>
         <input type="hidden" name="website_down" value="0"> <!-- Checkbox hack -->
         <tr>
            <td class='col-4 p-2'>Website maintenance</td>
            <td class="col-8 p-0">
               <div class="form-check form-switch d-flex justify-content-center">
                  <input type='checkbox' class='form-check-input' name='website_down' value='1' @if( $settings['website_down']==1 ) checked @endif >
               </div>
            </td>
         </tr>
         <input type="hidden" name="use_https" value="0"> <!-- Checkbox hack -->
         <tr>
            <td class='col-4 p-2'>Secure site with SSL (https)</td>
            <td class="col-8 p-0">
               <div class="form-check form-switch d-flex justify-content-center">
                  <input type='checkbox' class='form-check-input' name='use_https' value='1' @if( $settings['use_https']==1 ) checked @endif >
               </div>
            </td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Logo</td>
            <td class="col-8 p-3">
               <br>
               <?php 
                  $logo = null;
                  if(($settings['logo'] != '' && file_exists('storage/images/logos/' . $settings['logo']))){
                     $logo = $settings['logo'];
                  }
               ?>
               <div class="col-12 mb-3">
                  <input type="hidden" name="logo" value="<?= $logo ?>" >
                  <img id="logo" src="storage/images/logos/<?= $logo ?>" style="max-height:7.5rem;" alt="Select an image">
               </div>
               <div class="btn-group" role="group">
                  <button type='button' id="button-logo" class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#filemanager-modal'>{{ trans('actions.select') }}</button>
               </div>
            </td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Website type</td>
            <td class="col-8 p-0">
               <select name='website_type' class='form-select'>
                  <option value='website'>Website</option>
                  <option value='blog'>Blog</option>
               </select>
            </td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Blogposts on page</td>
            <td class="col-8 p-0"><input type='number' min='1' max='100' class='form-control' name='blogposts_on_page' value="{{$settings['blogposts_on_page']}}"></td>
         </tr>
         <tr>
            <td class='col-4 p-2'>Default Role</td>
            <td class="col-8 p-0">
               <select name='default_user_role' class='form-select'>
               @foreach($user_roles as $role)
               <option value='{{$role->id}}' @if(isset($settings['default_user_role']) && $role->id==$settings['default_user_role']) selected @endif @if($role->isAdminRole()) style='color:red;' @endif > {{$role->name}} </option>
               @endforeach
               </select>
            </td>
         </tr>
         <tr>
            <td class='col-4'></td>
            <td class="col-8 p-3">
               <button type='submit' class='btn btn-primary btn-lg'><span class='fa fa-floppy-o' aria-hidden='true'></span> {{ trans('settings.adminarea_save_settings') }}</button>
            </td>
         </tr>
      </tbody>
   </table>
</form>

<div id="filemanager-modal" class='modal' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabelx' aria-hidden='true'>
   <div class='modal-dialog modal-xl'>
      <div class='modal-content'>
         <div class='modal-header'>
            <h3 class='modal-title text-center'>Select Logo</h3>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
         </div>
         <div class='modal-body p-3' style="height:500px;">
            @include('media.filemanager', ['mode' => '', 'current_dir' => 'storage/images'])
         </div>
      </div>
   </div>
</div>

<script>
   var context = "";
   
   $("#button-favicon").on('click',function(event){
     context = "favicon";
   });
   
   $("#button-logo").on('click',function(event){
     context = "logo";
   });
   
   
   $("#workspace").on('click',".file",function(event) {
   
       if(context=="logo"){
   
         var src = $(event.target).attr('src');
         var bname = filemanager.basename(src)+"."+filemanager.getFileExtension(src);
         $('[name="logo"]').val(bname);
         $('#logo').attr('src', 'storage/images/logos/'+bname);
   
       }else if(context=="favicon"){
   
           var src = $(event.target).attr('src');
           var bname = filemanager.basename(src)+"."+filemanager.getFileExtension(src);
           $('[name="favicon"]').val(bname);
           $('#favicon').attr('src', 'storage/images/favicons/'+bname);
   
       }
   
       $('#filemanager-modal').modal("hide");
   
   });
</script>
@endsection