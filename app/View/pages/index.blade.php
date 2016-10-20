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

<script type="text/javascript" src='src/View/pages/dragndrop.js'></script>

<div class='container main-container'>


<h2>{{trans('page.pages')}} <small class='pull-right' style='margin-top:1.5%;'>{{trans('page.all')}}: {{$number_of_pages}} | {{trans('page.visible')}}: {{$visible_pages}} | {{trans('page.invisible')}}: {{$number_of_pages - $visible_pages}}</small></h2>

<br>
<div class='col-md-6'>
  <a href='page/create' class='btn btn-info' style='margin-bottom:20px;'>{{trans('page.create_page_button')}}</a>
</div>
<div class='col-md-6' style='text-align:right;'>
  <a class='btn btn-default' id='orderer' onclick='$(this).toggle(dragndroporder());' style='margin-bottom:20px;'><i class='fa fa-arrows-v' style='font-size:15px;'  aria-hidden='true'></i> {{trans('page.order')}}</a>
</div>

<table class='table table-hover table-condensed'>
    <thead>
      <tr>
      	<th>{{trans('page.th_id')}}</th>
        <th>{{trans('page.th_image')}}</th>
      	<th>{{trans('page.th_name')}}</th>
        <th>{{trans('page.th_template')}}</th>
        <th>{{trans('page.th_visibility')}}</th>
        <th>{{trans('page.th_type')}}</th>
        <th>{{trans('page.th_child_links')}}</th>
        <th><center>{{trans('actions.action')}}</center></th>
      </tr>
    </thead><tbody>

<?php 

foreach($all_pages as $each){

if($each->visibility==0)  {
    $class = 'danger';
}
else if($each->parent->id!=0){
   $class = 'bg-info';
}
else{
   $class = '';
}

echo "<tr class='".$class."'>";
echo  "<td>" .$each->id;


  //echo " <i class='clickable fa fa-plus' data-toggle='collapse' id='row1' data-target='.row1' style='font-size:20px;'></i>&nbsp&nbsp&nbsp";

  if($each->is($welcome_page)){
    echo " <i class='fa fa-home' style='font-size:20px;'></i>";
  }
  else{
    echo " <a href='#' data-toggle='modal' data-target='.mo-".$each->id."'><i class='fa fa-home' id='hidden-home' style='font-size:20px;'></i></a>";  
  }

    $each->language = 'EN';

    //$language = $each->getLanguage();

   // $language->setValue('lang_code','GB');

echo "<br><span class='label label-default label-sm'>".$each->language."</span>";

  echo "
        </td>
        <td><img src='" .$each->getThumb()."' width='70' height='50' class='img img-rounded' /></td>
        <td>" .$each->name."</td>
        <td>" .$each->url."</td>
        <td>";

        if($each->visibility==1){
          echo "<font color='green'>Visible</font>";
        }
        else{
          echo "<font color='red'>Invisible</font>";
        } 

  echo "</td>
        <td>";

        if($each->parent==0){
          echo "<b>Main</b>";
        }
        else{
          echo "Submenu <i>of</i></br><b>".$each->get_parent_page()->name."</b>";
        }

    echo "</td>";

        
    echo "<td style='padding-left:45px;'><span class='badge'>" .count($each->get_child_pages())."</span></td>";


      echo   "<td><center>";

      echo "
       <div class='btn-group' role='group'>
           <a href='page/update/".$each->id."' type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>{{trans('actions.edit')}}</a>
           <a  type='button' data-toggle='modal' data-target='.delete_".$each->id."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
       </div>";
      
      echo "</center></td></tr>";


echo '  
<div class="modal mo-'.$each->id.'" id=" mo-'.$each->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modal-header-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change HomePage</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to set <b>'.$each->name.'</b> as HomePage?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="page/home/'.$each->id.'" type="button" class="btn btn-primary">Set as Homepage</a>
      </div>
    </div>
  </div>
</div>';




   Bootstrap::delete_confirmation(
    "delete_".$each->id."",
    trans('actions.are_you_sure'),
    "<b>{{trans('actions.delete_this','page')}}: </b>".$each->name." <b>?</b>",
    "<a href='page/delete/".$each->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> {{trans('actions.delete')}}</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>".trans('actions.cancel')."</button>"
    );


    echo "</center></td></tr>";

/*foreach ($each->get_child_pages() as $child_page) {
  
    echo "<td colspan='8'><tr style='text-align:center;border-top: hidden !important;'>
            <td style='border-left:5px solid #428bca;'><i class='fa fa-caret-right' aria-hidden='true'></i> ".$child_page->id;

                if($data['welcome_page']->id==$child_page->id){
                  echo " <i class='fa fa-home' style='font-size:20px;'></i>";
                }
                else{
                  echo " <a href='#' data-toggle='modal' data-target='.mo-".$child_page->id."'><i class='fa fa-home' id='hidden-home' style='font-size:20px;'></i></a>";  
                }


            echo "</td>
            <td><img src='" .$each->get_thumb()."' width='40' height='30' class='img img-rounded' /></td>
            <td>".$child_page->name."</td>  
            <td>".$child_page->url."</td>
            <td>";


            if($each->visibility==1){
              echo "<font color='green'>Visible</font>";
            }
            else{
              echo "<font color='red'>Invisible</font>";
            } 

            echo "</td>
            <td>";

                    if($child_page->parent==0){
                        echo "<b>Main</b>";
                      }
                      else{
                        echo "Submenu <i>of</i></br><b>".$child_page->get_parent_page()->name."</b>";
                      }


            echo "</td>
            <td><span class='badge'>" .count($child_page->get_child_pages())."</span></td>  
            <td>
             <div class='btn-group' role='group'>
                 <a href='page/update/".$child_page->id."' type='button' class='btn btn-warning btn-sm'><i class='fa fa-pencil' aria-hidden='true'></i></a>
                 <a  type='button' data-toggle='modal' data-target='.delete_".$child_page->id."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
             </div></center></td>
              </tr></td>";



              echo '  
                <div class="modal mo-'.$child_page->id.'" id=" mo-'.$child_page->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header modal-header-warning">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Change HomePage</h4>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to set <b>'.$child_page->name.'</b> as HomePage?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a href="page/home/'.$child_page->id.'" type="button" class="btn btn-primary">Set as Homepage</a>
                      </div>
                    </div>
                  </div>
                </div>';





                 Bootstrap::delete_confirmation(
                  "delete_".$child_page->id."",
                  "Are you sure?",
                  "<b>Delete this page: </b>".$child_page->name." <b>?</b>",
                  "<a href='page/delete/".$child_page->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
                  <button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>"
                  );




    }*/

}

?>


	</tbody>
  </table>

</div>
@endsection
