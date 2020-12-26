@extends('layout')

@section('content')
<style>
#hidden-home{
    visibility:hidden;
}

tr:hover #hidden-home{
    visibility:visible;
    color:grey;
}

tr #hidden-home a:hover{
  color:black;
}

</style>

<div class='container main-container'>


<h2>{{trans('page.pages')}} <small class='pull-right' style='margin-top:1.5%;'>{{trans('page.all')}}: {{$number_of_pages}} | {{trans('page.visible')}}: {{$visible_pages}} | {{trans('page.invisible')}}: {{$number_of_pages - $visible_pages}}</small></h2>

<div class="row py-3">
    <div class='col-md-6'>
      <a href="{{admin_link('page-create')}}" class='btn btn-info my-auto' style='margin-bottom:20px;'>{{trans('page.create_page_button')}}</a>
    </div>
    <div class='col-md-6' style='text-align:right;'>
      <a class='btn btn-default my-auto' id='orderer' onclick='$(this).toggle(dragndroporder());' data-csrf="{{csrf_token()}}" style='margin-bottom:20px;'><i class='fa fa-arrows-v' style='font-size:15px;'  aria-hidden='true'></i> {{trans('page.order')}}</a>
    </div>
</div>

<table id="page-list-table" class='table table-hover table-condensed'>
    <thead>
      <tr class="bg-dark text-white">
      	<th>{{trans('page.th_id')}}</th>
        <th>{{trans('page.th_image')}}</th>
      	<th>{{trans('page.th_name')}}</th>
        <th>{{trans('page.th_template')}}</th>
        <th>{{trans('page.th_visibility')}}</th>
        <th>{{trans('page.th_type')}}</th>
        <th>{{trans('page.th_child_links')}}</th>
        <th><center>{{trans('actions.th_action')}}</center></th>
      </tr>
    </thead><tbody id="pages">

<?php 

foreach($all_pages as $each){

if(!$each->isActive()){
    $class = 'danger';
}
else if(isset($each->parent)){
   $class = 'bg-info';
}
else{
   $class = '';
}

echo "<tr class='".$class."'>";
echo  "<td>" .$each->id;


  //echo " <i class='clickable fa fa-plus' data-toggle='collapse' id='row1' data-target='.row1' style='font-size:20px;'></i>&nbsp&nbsp&nbsp";

  if($each->is($home_page)){
    echo " <i class='fa fa-home' style='font-size:20px;'></i>";
  }
  else{
    echo " <a href='admin/#' data-toggle='modal' data-target='.mo-".$each->id."'><i class='fa fa-home' id='hidden-home' style='font-size:20px;'></i></a>";  
  }

echo "<br><span class='label label-default label-sm'>".strtoupper($each->language)."</span>";

  echo "
        </td>
        <td><img src='" .$each->getThumb()."' width='70' height='50' class='img img-rounded' /></td>
        <td>" .$each->name."</td>
        <td>" .$each->url."</td>
        <td>";

        if($each->visibility==1){
          echo "<font color='green'>".trans('page.visible')."</font>";
        }
        else{
          echo "<font color='red'>".trans('page.invisible')."</font>";
        } 

  echo "</td>
        <td>";

        if($each->parent==NULL){
          echo "<b>".trans('page.menu_type1')."</b>";
        }
        else{
          echo trans('page.menu_type2',['parent_menu'=> $each->parent->name]);
        }

    echo "</td>";

        
    echo "<td style='padding-left:45px;'><span class='badge badge-dark'>" .$each->subpages->count()."</span></td>";


      echo   "<td><center>";

      echo "
       <div class='btn-group' role='group'>
           <a href='".admin_link('page-edit',$each->id)."' type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>".trans('actions.edit')."</a>
           <a  type='button' data-toggle='modal' data-target='.delete_".$each->id."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
       </div>";
      
      echo "</center></td></tr>";


echo '  
<div class="modal mo-'.$each->id.'" id=" mo-'.$each->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-warning bg-warning text-white">
        <h4 class="modal-title" id="myModalLabel">'.trans("page.change_homepage").'</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        '.trans("page.are_you_sure_to_set",["page_name" => $each->name]).'
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">'.trans('actions.close').'</button>
        <a href="admin/page/set-home-page/'.$each->id.'" type="button" class="btn btn-primary">'.trans('actions.set').'</a>
      </div>
    </div>
  </div>
</div>';




   Bootstrap::delete_confirmation(
    "delete_".$each->id."",
    trans('actions.are_you_sure'),
    "<b>".trans('actions.delete_this',['content_type'=>'page']).": </b>".$each->name." <b>?</b>",
    "<a href='".admin_link('page-delete',$each->id)."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> ".trans('actions.delete') ."</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
    );


    echo "</center></td></tr>";

}

?>


	</tbody>
  </table>

    <center>
        {{$all_pages->links()}}
    </center>

</div>
@endsection
