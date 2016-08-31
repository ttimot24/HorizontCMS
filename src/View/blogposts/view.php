<div class='container main-container'>


<section class='row'>
<h1 class='col-md-8'>Blogpost view</h1>

<nav class='col-xs-12 col-md-4 '>
  <ul class='pager'>
<?php 

$indexes = array();
foreach($data['all'] as $each){
  array_push($indexes,$each->id);
}

$key = array_search($data['instance']->id,$indexes);

  if(isset($indexes[$key+1])){
  echo "<li class='next' id='next'><a href='admin/blogpost/view/". $indexes[$key+1] ."'>Newer  <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span></a></li>";
    }
  if(isset($indexes[$key-1])){
  echo "<li class='next' id='prev'><a href='admin/blogpost/view/". $indexes[$key-1] ."'> <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span> Older</a></li>";
  }

?>

  </ul>
</nav>
</section>


<section class='row'>
<div class='col-md-4'>
<button type='button' class='btn btn-link' data-toggle='modal' data-target='.<?= $data['instance']->id ?>-modal-xl'>
  <img src=<?= $data['instance']->get_image(); ?> width='350' class='img img-thumbnail' style='margin-top:20px;' />
</button>
</br><center>
  <div class='btn-group' role='group'>
    <a href='' type='button' class='btn btn-success'><span class='glyphicon glyphicon-star' aria-hidden='true'></span> Primary</a>
    <a href=admin/blogpost/update/<?= $data['instance']->id ?> type='button' class='btn btn-warning'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> Edit post</a>
    
    <button type='button' class='btn btn-danger' data-toggle='modal' data-target='.delete'>
    <span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete
    </button>
  </div>


    </br></br><b>Author : </br><a href='admin/user/view/<?= $data["instance"]->get_author()->id?>'><?= $data['instance']->get_author()->username ?></a></b>
    </br></br><b>Published on : </br><a><?= date('Y.m.d. H:i:s',$data['instance']->date) ?></a></b>
    </br></br><b>Category : </br><a><?= $data['instance']->get_category()->name ?></a></b>
    </br></br><b>Characters : <a><?= strlen($data['instance']->text) ?></a></b>
    </center>
</div>

<div class="col-md-8" style='text-align:justify;padding-top:2.5%;'>
  <div class='well'>
    <h3><?= $data['instance']->title ?></h3><hr/>
    <b><?= $data['instance']->summary ?></b>
    <p style='margin-top:40px;'>
    <?= $data['instance']->text ?>
    </p>
  </div>  
    </td>
</div>
</section>
<div id='comments'></div>
</br></br>


<?php 

  Bootstrap::image_details($data['instance']->id,$data['instance']->get_image());


  Bootstrap::delete_confirmation(
    "delete",
    "Are you sure?",
    "<b>Delete this post: </b>". $data['instance']->title." <b>?</b>",
    "<a href='admin/blogpost/delete/".$data['instance']->id."' type='button' class='btn btn-danger'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> Delete</a>
    <button type='button' class='btn btn-default' data-dismiss='modal'>Cencel</button>"
    );
?>







<?php //@$this->renderPartial("blogposts/comments",['blogpost' => $data['instance'],'comments' => $data['comments']]);

  require_once(VIEW_DIR."blogposts/comments.php");

?>



</div>


<script>

/*$(window).keydown(function(event) {
    switch(event.which) {
        case 37: // left
                 window.location.replace('admin/blogpost/view/' + <?= $indexes[$key-1]; ?>);
                 break;

        case 39: // right
                  window.location.replace('admin/blogpost/view/' + <?= $indexes[$key+1]; ?>);
                  break;

        default: return; // exit this handler for other keys
    
    }
    e.preventDefault();
});*/


</script>