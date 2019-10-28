<?php 

	if(isset(Website::$_SLUGS[1])){
		$blogpost = \App\Model\Blogpost::findBySlug(Website::$_SLUGS[1]);
		echo "<div class='well'>";
		echo "<h1>".$blogpost->title."</h1><br>";

		if($blogpost->hasImage() && file_exists('storage/images/blogposts/'.$blogpost->image)){
			echo "<center><img style='max-width:100%;' src='storage/images/blogposts/".$blogpost->image ."'></center>";
		}

		echo "<h3>".$blogpost->summary."</h3>";

		echo "<p>".$blogpost->text."</p>";

		echo "</div>";
		return;
	}


?>

<div style="width:100%;">
<h1 class="page-header"><?= Website::$_REQUESTED_PAGE->name ?></h1><br>
<?php $all_blogposts = \App\Model\Blogpost::orderBy('id','desc')->paginate(\Settings::get('blogposts_on_page')) ?>

<?php foreach($all_blogposts as $blogpost): ?>
<div class="well">
	<?php if($blogpost->isDraft()){continue;} ?>
	<img class="img-rounded" src="<?= $blogpost->getImage() ?>" style="width:100%;height:400px;object-fit:cover;">
	<h2><a href="<?= str_slug(Website::$_REQUESTED_PAGE->name).'/'.str_slug($blogpost->title) ?>"><?= $blogpost->title ?></a></h2>
	<p style="padding-left:5px;">Written by <a href="#"><?= $blogpost->author->username ?></a> on <a href="#"><?= $blogpost->created_at->diffForHumans() ?></a> in <a href="#"><?= $blogpost->category->name ?></a></p>
	<p><b><?= $blogpost->getExcerpt() ?></b></p>
	<p></p>
</div>
	<hr>
<?php endforeach; ?>


<center>
<?= $all_blogposts->links() ?>
</center>
<br>

</div>