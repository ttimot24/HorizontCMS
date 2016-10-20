<?php



	if(isset(Website::$_SLUGS[1]) && Website::$_SLUGS[1]=='post' && isset(Website::$_SLUGS[2])){

		$blogpost = Website::$_BLOGPOST->get_instance_by_name(Website::$_SLUGS[2]);

		print "<div class='news'>";

			print "<h2 style='margin-bottom:-0.5px;'>".$blogpost->title."</h2></br>";
			print "<p><b>".$blogpost->summary."</b></p></br>";
			print "<p>".$blogpost->text."</p>";
			print "<p><center><img src='".$blogpost->get_image()."'></center></p>";
			print "<div class='news_meta' style='float:left;width:50%;'>Posted in <a href=''>" .$blogpost->get_category()->name ."</a></div>";
			print "<div class='news_meta' style='text-align:right;'>Posted on <a href=''>".date('Y:m:d-H:i:s',$blogpost->date)."</a> by <a href=''>".$blogpost->get_author()->name."</a></div>";

			print "</br></br>";


			print "<hr/>";

			require_once("comment.php");

			print "</br></br>";
		print "</div>";



	}
	else{

		if(!isset($_GET['category']) /*&& $_GET['category']==''*/){
			$all_blogpost = Website::$_BLOGPOST->get_all_blogpost();
		}
		else{
			$all_blogpost = Website::$_BLOGPOST->get_blogpost_by_category_id($_GET['category']);
		}

		print "<div class='news'>";
		foreach($all_blogpost as $each){

			print "<h2 style='margin-bottom:-0.5px;'><a id='news_title' href='".UrlManager::seo_url(Website::$_REQUESTED_PAGE->name."/post/".$each->title)."'>".$each->title."</a></h2>";
			print "<div class='news_meta'>Posted on <a href=''>".date('Y:m:d-H:i:s',$each->date)."</a> by <a href=''>".$each->get_author()->username."</a></div></br>";
			print "<p>".$each->summary."</p>";
			print "<p><center><img src='".$each->get_image()."' width='450'></center></p>";
			print "<div class='news_meta'>Posted in <a href='index.php?category=".$each->id."'>".$each->get_category()->name."</a> | Comments: <a href=''>" .count($each->get_comments()). "</a> | <a href=''>Leave a comment</a></div>";

			print "</br></br>";
		}
		print "</div>";


	}

?>