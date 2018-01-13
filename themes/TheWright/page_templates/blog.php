<?php 

	if(isset(Website::$_SLUGS[1])){
		$blogpost = \App\Model\Blogpost::findBySlug(Website::$_SLUGS[1]);

		echo "<h1>".$blogpost->title."</h1>";

		if($blogpost->hasImage() && file_exists('storage/images/blogposts/'.$blogpost->image)){
			echo "<img src='storage/images/blogposts/".$blogpost->image ."'>";
		}

		echo "<h3>".$blogpost->summary."</h3>";

		echo "<p>".$blogpost->text."</p>";

		return;
	}


?>

<div style="width:100%;">
<h1 class="page-header"><?= Website::$_REQUESTED_PAGE->name ?></h1><br>
<?php $all_blogposts = \App\Model\Blogpost::orderBy('id','desc')->paginate(5) ?>

<?php foreach($all_blogposts as $blogpost): ?>
	<img class="img-rounded" src="<?= $blogpost->getImage() ?>" style="width:100%;height:400px;object-fit:cover;">
	<h2><a href="<?= str_slug(Website::$_REQUESTED_PAGE->name).'/'.str_slug($blogpost->title) ?>"><?= $blogpost->title ?></a></h2>
	<p style="padding-left:5px;">Written by <a href="#"><?= $blogpost->author->username ?></a> on <a href="#"><?= $blogpost->created_at->diffForHumans() ?></a> in <a href="#"><?= $blogpost->category->name ?></a></p>
	<p><b><?= $blogpost->getExcerpt() ?></b></p>
	<p></p>
	<hr>
<?php endforeach; ?>


<center>
<?= $all_blogposts->links() ?>
</center>
<br>

</div>