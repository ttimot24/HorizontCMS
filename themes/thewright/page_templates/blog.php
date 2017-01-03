<div style="width:100%;">
<h1><?= Website::$_REQUESTED_PAGE->name ?></h1><br>
<?php $all_blogposts = \App\Model\Blogpost::orderBy('id','desc')->paginate(5) ?>

<?php foreach($all_blogposts as $blogpost): ?>
	<img class="img-rounded" src="<?= $blogpost->getImage() ?>" style="width:100%;height:400px;object-fit:cover;">
	<h2><a href="#"><?= $blogpost->title ?></a></h2>
	<p style="padding-left:5px;">Written by <a href="#"><?= $blogpost->author->username ?></a> on <a href="#">2016.12.08 13:55:49</a></p>
	<p><b><?= $blogpost->getExcerpt() ?></b></p>
	<p></p>
	<hr>
<?php endforeach; ?>


<center>
<?= $all_blogposts->links() ?>
</center>
<br>

</div>