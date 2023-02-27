@extends('layout')

@section('content')

<div class='container main-container'>


<h2>{{trans('page.pages')}} <small class='pull-right text-muted pt-3'>{{trans('page.all')}}: {{$number_of_pages}} | {{trans('page.visible')}}: {{$visible_pages}} | {{trans('page.invisible')}}: {{$number_of_pages - $visible_pages}}</small></h2>

<div class="row py-3">
    <div class='col-md-6'>
      <a href="{{route('page.create')}}" class='btn btn-info my-auto'>{{trans('page.create_page_button')}}</a>
    </div>
    <div class='col-md-6 text-right text-end'>
      <a class='btn btn-default my-auto' id='orderer' onclick='dragndroporder();' data-csrf="{{csrf_token()}}"><i class='fa fa-arrows-v' style='font-size:15px;'  aria-hidden='true'></i> {{trans('page.order')}}</a>
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
        <th class="text-center">{{trans('actions.th_action')}}</th>
      </tr>
    </thead><tbody id="pages">



@foreach($all_pages as $each)

<?php 

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

  if($each->is($home_page)){
    echo " <i class='fa fa-home' style='font-size:20px;'></i>";
  }
  else{
    echo " <a href='admin/#' data-bs-toggle='modal' data-bs-target='.mo-".$each->id."'><i class='fa fa-home' id='hidden-home' style='font-size:20px;'></i></a>";  
  }

echo "<br><span class='badge bg-secondary'>".strtoupper($each->language)."</span>";

  echo "
        </td>
        <td><img src='" .$each->getThumb()."' width='70' height='50' class='img img-rounded' /></td>
        <td>" .$each->name."</td>
        <td>" .$each->url."</td>
        <td>";

        if($each->visibility==1){
          echo "<p class='text-success'>".trans('page.visible')."</p>";
        }
        else{
          echo "<p class='text-danger'>".trans('page.invisible')."</p>";
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

        
    echo "<td class='ps-4'><span class='badge rounded-pill bg-dark'>" .$each->subpages->count()."</span></td>


    <td class='text-center'>
       <div class='btn-group' role='group'>
           <a href='".route('page.edit',['page' => $each])."' type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>".trans('actions.edit')."</a>
           <a  type='button' data-bs-toggle='modal' data-bs-target='#delete_".$each->id."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
       </div>
      
      </td>
      </tr>";


echo '  
<div class="modal mo-'.$each->id.'" id=" mo-'.$each->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-warning bg-warning text-white">
        <h4 class="modal-title" id="myModalLabel">'.trans("page.change_homepage").'</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        '.trans("page.are_you_sure_to_set",["page_name" => $each->name]).'
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">'.trans('actions.close').'</button>
        <a href="admin/page/set-home-page/'.$each->id.'" type="button" class="btn btn-primary">'.trans('actions.set').'</a>
      </div>
    </div>
  </div>
</div>';
?>
  </td></tr>

    @include('confirm_delete', [
          "route" => route('page.destroy',['page' => $each]),
          "id" => "delete_".$each->id,
          "header" => trans('actions.are_you_sure'),
          "name" => $each->title,
          "content_type" => "page",
          "delete_text" => trans('actions.delete'),
          "cancel" => trans('actions.cancel')
          ]
    )

@endforeach


	</tbody>
  </table>

    <div class="d-flex justify-content-center">
        {{$all_pages->links()}}
    </div>

</div>
@endsection
