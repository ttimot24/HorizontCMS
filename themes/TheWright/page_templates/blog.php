<?php 

	if(isset(Website::$_SLUGS[1])){
		$blogpost = \App\Model\Blogpost::findBySlug(Website::$_SLUGS[1]);
		echo "<div class='well'>";
		echo "<h1>".$blogpost->title."</h1>";
		echo "<h5 class='pull-right'><a>".$blogpost->author->username."</a> | ".$blogpost->created_at."</h5><br>";

		echo Website::$message->note("This is a draft post.");  

		if($blogpost->hasImage() && file_exists('storage/images/blogposts/'.$blogpost->image)){
			echo "<center><img style='max-width:100%;' src='storage/images/blogposts/".$blogpost->image ."'></center>";
		}

		echo "<h3>".$blogpost->summary."</h3>";

		echo "<p>".$blogpost->text."</p>";

		echo "</div>";
		return;
	}


?>

<div class="col-md-12"> 

<h1 class="page-header"><?= Website::$_REQUESTED_PAGE->name ?></h1><br>


<?php $all_blogposts = \App\Model\Blogpost::orderBy('id','desc')->paginate(\Settings::get('blogposts_on_page')) ?>

<section>
<?php foreach($all_blogposts as $blogpost): ?>
	<?php if($blogpost->isDraft()){continue;} ?>

	<?php if($blogpost->isFeatured()): ?>
		<div class="well card card-body col-md-12">
		<div class="col">
			<img class="img img-rounded col-md-12" src="<?= $blogpost->getImage() ?>" style="object-fit:cover;margin-bottom:15px;">
			<h2><a href="<?= str_slug(Website::$_REQUESTED_PAGE->name).'/'.str_slug($blogpost->title) ?>"><?= $blogpost->title ?></a></h2>
			<p style="padding-left:5px;">Written by <a href="#"><?= $blogpost->author->username ?></a> on <a href="#"><?= $blogpost->created_at->diffForHumans() ?></a> in <a href="#"><?= $blogpost->category->name ?></a></p>
			<p><b><?= $blogpost->getExcerpt() ?></b></p>
		</div>
		</div>
	<?php else: ?>
		<div class="well card card-body col-md-12">
		
			<div class="col">
				<div class="col-md-5">
					<img class="img img-rounded" src="<?= $blogpost->getImage() ?>" >
				</div>
				<div class="col-md-7">
					<h2><a href="<?= str_slug(Website::$_REQUESTED_PAGE->name).'/'.str_slug($blogpost->title) ?>"><?= $blogpost->title ?></a></h2>
					<p class="pl-1" style="padding-left:5px;">Written by <a href="#"><?= $blogpost->author->username ?></a> on <a href="#"><?= $blogpost->created_at->diffForHumans() ?></a> in <a href="#"><?= $blogpost->category->name ?></a></p>
					<p><b><?= $blogpost->getExcerpt() ?></b></p>
				</div>
			</div>
		
		</div>
	<?php endif; ?>

<?php endforeach; ?>
</section>

<center>
<?= $all_blogposts->links() ?>
</center>
<br>

</div>