<?php


		print "<h4>Search</h4>";
		print "<div class='news_meta'>";

		print "<form action='' method='GET'>
				<input type='text' name='search' size='18'/>
				<button type='submit'>Search</button>
				</form>";

		print "</div>";

		print "<h4>Meta</h4>";
		print "<div class='news_meta'>";

		if(!isset($_SESSION['username']) || $_SESSION['username']==''){
		print "<li><a href='../../'>Log in</a></li>";
		print "<li><a href=''>Register</a></li>";
		}
		else{
		print "<li><a href='../../'>AdminArea</a></li>";
		print "<li><a href='admin/login/logout'>Log out</a></li>";
		}

		print "</div>";

//		print "<h4>Latest posts</h4>";







		/*$_BLOGPOSTS = new Blogpost();
		$latest = $_BLOGPOSTS->get_latest_blogposts(3);
		print "<div class='news_meta'>";
		foreach ($latest as $each) {
			print "<li><a href='index.php?post=".$each->id."'>".$each->title."</a></li>";
		}
		print "</div>";


		print "<h4>All category</h4>";
		$_CATEGORY = new Category();
		$categ = $_CATEGORY->get_all_categories();
		print "<div class='news_meta'>";
		foreach ($categ as $each) {
			print "<li><a href='index.php?category=".$each->id."'>".$each->name." (".$each->count_posts().")</a></li>";
		}*/





		
//		print "</div>";

		print "</br></br>";



		Plugin::area(1);
?>