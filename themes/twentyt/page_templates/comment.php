<?php

if(isset($_POST['comment']) && $_POST['comment']!=''){

	$query_status = System::$connection->query("INSERT INTO ".PREFIX."blogpost_comment VALUES(default,".$blogpost->id.",".$_SESSION['id'].",'".time()."','".$_POST['comment']."')");

	if(!$query_status){
		print "<p style='color:red'>Something went wrong! <u>".System::$connection->error."</u></p>";
	}

}


print "<div class='comment'>";

$comments = $blogpost->get_comments();

print "<h2>Comments (".count($comments).")</h2>";

if($comments==NULL){
print "<p>There is no comment yet. Be the first. ";

	if(!isset($_SESSION['username']) || $_SESSION['username']==''){
		print "<a href='#'>Log in</a>";
	}
}
else{

	print "<table>";
	foreach($comments as $each){
		$user = Website::$_USER->get_instance($each->user_id);

		print "<tr><td valign='top'><img src='".$user->get_image()."' width='70' style='float:left;margin-right:10px;'/> </td>";
		print "<td style='padding-bottom:40px;'><p><a href='#'><b>" .$user->username ."</b></a> <i>says:</i></br> <font size='2'>" .date("Y.m.d-H:i:s",$each->date) ."</font></br>".$each->comment ."</p>";
		print "<div class='news_meta'><a href=''>Reply</a></div></td></tr>";
	}
	print "</table>";
}

if(isset($_SESSION['username']) && $_SESSION['username']!=""){
		print "<form action='".UrlManager::seo_url(Website::$_REQUESTED_PAGE->name."/post/".$blogpost->title)."' method='POST'>";
		print "<p>Comment as: <b>".$_SESSION['username']."</b></p>";
		print "<textarea name='comment' rows='10' cols='85'></textarea></br>";
		print "<button type='submit' >Send</button>";
		print "</form>";
}


print "</p>";

print "</div>";
?>