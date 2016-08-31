<?php

print "<h2>Search</h2>";


$_BLOGPOSTS = new Blogpost();

$finds = $_BLOGPOSTS->search($_GET['search']);

foreach ($finds as $each) {
	print "<h4>" .$each->title ."</h4>";
	print "<p style='max-height:45px; overflow:hidden;'>". $each->summary ."</p>";
	print "<a href='index.php?post=".$each->id."'>Read more</a>";
}

?>