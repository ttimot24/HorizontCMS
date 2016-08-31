<div class='container main-container'>

<h2 style='width:50%;' class='pull-left'>Found <a><?= (count($data['blogposts'])+count($data['users'])+count($data['pages'])+count($data['files'])) ?> </a> matches for the keyword '<a><?= $data['search_for']; ?></a>'</h2> 

<form class='form-inline' action='admin/search' method='POST'>
<br>
          <div class='form-group pull-right'>
            <div class='input-group'>
            <input type='text' class='form-control' name='search' id='exampleInputAmount' style='width:250px;' placeholder='<?= $this->language['search_bar'] ?>' required>
               <div class='input-group-addon'>
                <button type='submit' class='btn btn-link btn-sm'  style='margin:0px;padding:0px;'>
               <span class='glyphicon glyphicon-search' aria-hidden='true' size=1></span></div>
               </button>
            </div>
          </div>
         <!-- <button type='submit' class='btn btn-primary'>Search</button>-->
        </form>

<!-- <a href='admin/dashboard'>
          <button type='button' class='btn btn-primary' class='pull-right' style='margin-left:5%;'><?= $this->language['dashboard'] ?></button>
  </a>-->


</br></br></br>


<h3 style='clear:both;'><?= $this->language['news_match'] ?> (<?= count($data['blogposts']) ?>)</h3>
<div class='container'>
<?php 
foreach ($data['blogposts'] as $each) {
	echo "<a href='admin/blogpost/view/".$each->id."'>" .$each->title ."</a></br>";
}

?>
</div>


<h3><?= $this->language['users_match'] ?> (<?= count($data['users']) ?>)</h3>
<div class='container'>

<?php 
foreach ($data['users'] as $each) {
	echo "<a href='admin/user/view/".$each->id."'>" .$each->username ."</a></br>";
}

?>
</div>


<h3><?= $this->language['pages_match'] ?> (<?= count($data['pages']) ?>)</h3>
<div class='container'>
<?php 
  foreach ($data['pages'] as $each) {
  	echo "<a href='admin/page/view/".$each->id."'>" .$each->name ."</a></br>";
  }
?>
</div>

<h3><?= $this->language['files_match'] ?> (<?= count($data['files']) ?>)</h3>
<div class='container'>
<?php 
    foreach ($data['files'] as $each) {
      echo "<a href=''>" .$each ."</a></br>";
    }
?>
</div>


</br></br></br></br></br>
