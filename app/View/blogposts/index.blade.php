@extends('layout')

@section('content')
<div class='container main-container'>

<h2>Posted news <small class='pull-right' style='margin-top:1.5%;'>All: {{$number_of_blogposts}}</small></h2></br>
<div class='container'>
  <a href='admin/blogpost/newpost' class='btn btn-primary' style='margin-bottom:20px;'>New post</a>
</div>

<table class='table table-hover'>
    <thead>
      <tr>
      	<th>Id</th>
        <th>Image</th>
      	<th>Title</th>
      	<th>Comments</th>
        <th>Date</th>
        <th>Author</th>
        <th>Category</th>
        <th><center>Action</center></th>
      </tr>
    </thead><tbody>



<?php foreach($all_blogposts as $blogpost): ?>

<tr>
  <td><?= $blogpost->id ?></td>


  <td><img src=<?php //$blogpost->get_thumb(); ?>  class='img img-rounded' style='object-fit:cover;' width=70 height=50 /> </td>


  <td  class='col-md-5'><a href=admin/blogpost/view/<?= $blogpost->id; ?> ><?= $blogpost->title; ?></a></td>
  		 <td><center><span class="badge" style='font-size:14px'><?php //count($blogpost->get_comments()) ?></span></center></td>
  

  <td><?= date('Y-m-d',$blogpost->date); ?></br><font size='2'><i>at</i> <?= date('H:i:s',$blogpost->date) ?></font></td>
         <td><a href=admin/user/view/<?php //$blogpost->get_author()->id ?> >
         <?php //$blogpost->get_author()->username ?></a></td>
         <td><span class="label label-success" style='font-size:14px; display:block'><?php // $blogpost->get_category()->name ?></span></td>



  <td>
    <center>

       <div class="btn-group" role="group">
           <a href=admin/blogpost/update/<?= $blogpost->id ?> type="button" class="btn btn-warning btn-sm" style='min-width:70px;'>Edit</a>
           <a type="button" data-toggle='modal' data-target=.delete_<?= $blogpost->id ?> class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
       </div>

        </center>
  </td>
</tr>

<?php 

 /*  Bootstrap::delete_confirmation(
    "delete_".$blogpost->id."",
    "Are you sure?",
    "<b>Delete this post: </b>".$blogpost->title." <b>?</b>",
    "<a href='admin/blogpost/delete/".$blogpost->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>"
    );*/

?>


<?php endforeach; ?>


</tbody>
  </table>


<!--
<?php //if($data['show_pagination']!=FALSE): ?>
<hr/><b>Page:&nbsp&nbsp</b>
<div class='page_list' style='clear:both;'>
<ul class='pagination'>
<?php 
        /*  for($i=1;$i<=$data['pages_number'];$i++){

            if($data['page']==$i){
              echo "<li class='active'><a href='admin/blogpost/page/".$i."'>" .$i."</a></li>&nbsp&nbsp";
            }else{
              echo "<li><a href='admin/blogpost/page/".$i."'>" .$i ."</a></li>&nbsp&nbsp";
            }

          }*/

?>

</ul></div>
<?php //endif; ?>-->


</div>
@stop