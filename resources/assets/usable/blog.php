<?php

	$_BLOGPOST = new Blogpost();
	$_CATEGORY = new Category();



	if($_GET['post']!=''){

		$blogpost = $_BLOGPOST->get_blogpost($_GET['post']);

		print "<div class='news'>";

			print "<h2 style='margin-bottom:-0.5px;'>".$blogpost->title."</h2>";
			print "<p><b>".$blogpost->summary."</b></p></br>";
			print "<p>".$blogpost->text."</p>";
			print "<p><center><img src='".$blogpost->get_image("../../images/news")."'></center></p>";
			print "<div class='news_meta' style='float:left;width:50%;'>Posted in <a href=''>".$_CATEGORY->get_category_by_id($blogpost->category)->name."</a></div>";
			print "<div class='news_meta' style='text-align:right;'>Posted on <a href=''>".$blogpost->date."</a> by <a href=''>".$blogpost->get_author_name()."</a></div>";

			print "</br></br>";


			print "<hr/>";

			require_once("comment.php");

			print "</br></br>";
		print "</div>";



	}
	else{

		if($_GET['category']==''){
			$all_blogpost = $_BLOGPOST->get_all_blogpost();
		}
		else{
			$all_blogpost = $_BLOGPOST->get_blogpost_by_category_id($_GET['category']);
		}

		print "<div class='news'>";
		foreach($all_blogpost as $each){

			print "<h2 style='margin-bottom:-0.5px;'><a id='news_title' href='index.php?page=".$_GET['page']."&post=".$each->id."'>".$each->title."</a></h2>";
			print "<div class='news_meta'>Posted on <a href=''>".$each->date."</a> by <a href=''>".$each->get_author_name()."</a></div>";
			print "<p>".$each->summary."</p>";
			print "<p><center><img src='".$each->get_image("../../images/news")."' width='450'></center></p>";
			print "<div class='news_meta'>Posted in <a href='index.php?category=".$each->id."'>".$each->category."</a> | Comments: <a href=''>" .count($each->get_comments()). "</a> | <a href=''>Leave a comment</a></div>";

			print "</br></br>";
		}
		print "</div>";


	}

?>