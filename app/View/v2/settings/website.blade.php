@extends('layout')
@section('content')
<div class='container main-container'>
<h1>Website settings</h1>
<br><br>
<form action='{{admin_link("settings-save")}}' role='form' method='POST'>
   {{ csrf_field() }}
   <table class='table-bordered' id='settings' style='width:100%;text-align:center;'>
      <tbody style='font-weight:bolder;'>
         <tr class="d-flex">
            <td class='col-4'>Title<br><small class='text-muted'>What you write here, will be the name of the browser page.</small></td>
            <td class="col-8"><input type='text' class='form-control' name='title' value="{{$settings['title']}}"></td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Site name</td>
            <td class="col-8"><input type='text' class='form-control' name='site_name' value="{{$settings['site_name']}}"></td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Slogan</td>
            <td class="col-8"><input type='text' class='form-control' name='slogan' value="{{$settings['slogan']}}"></td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Warning text</td>
            <td class="col-8"><input type='text' class='form-control' name='scroll_text' value="{{$settings['scroll_text']}}"></td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Favicon</td>
            <td class="col-8">
               <input type="hidden" name="favicon" value="<?=($settings['favicon'] != '' && file_exists('storage/images/favicons/' . $settings['favicon'])) ? $settings['favicon'] : ''?>" >
               <img id="favicon" class='<?=($settings['favicon'] != '' && file_exists('storage/images/favicons/' . $settings['favicon'])) ? "well well-sm" : ""?>' src="<?=($settings['favicon'] != '' && file_exists('storage/images/favicons/' . $settings['favicon'])) ? 'storage/images/favicons/' . $settings['favicon'] : ''?>" height='50' alt="">
               <div class="btn-group" role="group">
                  <button type='button' id="button-favicon" class='btn btn-success btn-sm' data-toggle='modal' data-target='.admin_logo_select-modal-lg'>Select</button>
               </div>
            </td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Debug mode</td>
            <td class="col-8">
               <div class='form-group pull-left col-xs-12 col-md-8 d-flex' style='margin-top:20px;margin-bottom:20px;'>
                  <div class="radio radio-primary radio-inline">
                     <input type="radio" id="inlineRadio1" value="1" name='website_debug' <?php if ($settings['website_debug'] == 1) {echo "checked";}?>>
                     <label for="inlineRadio1">On</label>
                  </div>
                  <div class="radio radio-inline">
                     <input type="radio" id="inlineRadio2" value="0" name='website_debug' <?php if ($settings['website_debug'] == 0) {echo "checked";}?>>
                     <label for="inlineRadio2">Off</label>
                  </div>
               </div>
            </td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Email</td>
            <td class="col-8"><input type='email' class='form-control' name='default_email' value="{{$settings['default_email']}}"></td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Contact info</td>
            <td class="col-8"><textarea rows='7' class='form-control' name='contact' cols='30'>{{ $settings['contact'] }}</textarea></td>
         </tr>
         <input type="hidden" name="website_down" value="0"> <!-- Checkbox hack -->
         <tr class="d-flex">
            <td class='col-4'>Website down</td>
            <td class="col-8"><input type='checkbox' class='form-control' name='website_down' value='1' <?php if ($settings['website_down'] == 1) {echo 'checked';}?> ></td>
         </tr>
         <input type="hidden" name="use_https" value="0"> <!-- Checkbox hack -->
         <tr class="d-flex">
            <td class='col-4'>Secure site with SSL (https)</td>
            <td class="col-8"><input type='checkbox' class='form-control' name='use_https' value='1' <?php if ($settings['use_https'] == 1) {echo 'checked';}?> ></td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Logo</td>
            <td class="col-8">
               <br>
               <input type="hidden" name="logo" value="<?=($settings['logo'] != '' && file_exists('storage/images/logos/' . $settings['logo'])) ? $settings['logo'] : ''?>" >
               <img id="logo" class='<?=($settings['logo'] != '' && file_exists('storage/images/logos/' . $settings['logo'])) ? "well well-sm" : ""?>' src="<?=($settings['logo'] != '' && file_exists('storage/images/logos/' . $settings['logo'])) ? 'storage/images/logos/' . $settings['logo'] : ''?>" height='100' alt="">
               <div class="btn-group" role="group">
                  <button type='button' id="button-logo" class='btn btn-success btn-sm' data-toggle='modal' data-target='.admin_logo_select-modal-lg'>Select</button>
               </div>
            </td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Website type</td>
            <td class="col-8">
               <select name='website_type' class='form-control'>
                  <option value='website'>Website</option>
                  <option value='blog'>Blog</option>
               </select>
            </td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Blogposts on page<br><small class='text-muted'>Number of blogposts per page</small></td>
            <td class="col-8"><input type='number' min='1' max='100' class='form-control' name='blogposts_on_page' value="{{$settings['blogposts_on_page']}}"></td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'>Default Role<br><small class='text-muted'>The role that is assigned to a newly registered user.</small></td>
            <td class="col-8">
               <select name='default_user_role' class='form-control'>
               @foreach($user_roles as $role)
               <option value='{{$role->id}}' @if(isset($settings['default_user_role']) && $role->id==$settings['default_user_role']) selected @endif @if($role->isAdminRole()) style='color:red;' @endif > {{$role->name}} </option>
               @endforeach
               </select>
            </td>
         </tr>
         <tr class="d-flex">
            <td class='col-4'></td>
            <td class="col-8">
               <br>
               <button type='submit' class='btn btn-primary btn-lg'><span class='fa fa-floppy-o' aria-hidden='true'></span> Save settings</button>
               <br><br>
            </td>
         </tr>
      </tbody>
   </table>
</form>
<div class='modal admin_logo_select-modal-lg' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabelx' aria-hidden='true'>
   <div class='modal-dialog modal-xl'>
      <div class='modal-content'>
         <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
            <h3 class='modal-title'>
               <center>Select Logo</center>
            </h3>
         </div>
         <div class='modal-body' style="padding:0px;height:500px;">
            @include('media.filemanager', ['mode' => '', 'current_dir' => 'storage/images/logos'])
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
         $('#logo').addClass('well well-sm');
   
       }else if(context=="favicon"){
   
           var src = $(event.target).attr('src');
           var bname = filemanager.basename(src)+"."+filemanager.getFileExtension(src);
           $('[name="favicon"]').val(bname);
           $('#favicon').attr('src', 'storage/images/favicons/'+bname);
           $('#favicon').addClass('well well-sm');
   
       }
   
       $('.admin_logo_select-modal-lg').modal("hide");
   
   });
</script>
@endsection