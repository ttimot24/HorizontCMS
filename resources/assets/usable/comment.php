<?php

if($_POST['comment']!=''){
	$date = date('Y.m.d-H:i:s');
	$query_status = $mysqli->query("INSERT INTO news_comments VALUES(default,".$_GET['post'].",".$_SESSION['id'].",'".$date."','".$_POST['comment']."')");

	if(!$query_status){
		print "<p style='color:red'>Something went wrong!</p>";
	}

}


$_USER = new User();

print "<div class='comment'>";

$comments = $blogpost->get_comments();

print "<h2>Comments (".count($comments).")</h2>";

if($comments==NULL){
print "<p>There is no comment yet. Be the first. ";

	if($_SESSION['username']==''){
		print "<a href='#'>Log in</a>";
	}
}
else{

	print "<table>";
	foreach($comments as $each){
		$user = $_USER->get_user($each['user_id']);

		print "<tr><td valign='top'><img src='../../images/profiles/".$user->get_image("../../images/profiles/")."' width='70' style='float:left;margin-right:10px;'/> </td>";
		print "<td style='padding-bottom:40px;'><p><a href='#'><b>" .$user->username ."</b></a> <i>says:</i></br> <font size='2'>" .$each['date'] ."</font></br>".$each['comment'] ."</p>";
		print "<div class='news_meta'><a href=''>Reply</a></div></td></tr>";
	}
	print "</table>";
}

if($_SESSION['username']!=NULL){
		print "<form action='index.php?post=".$_GET['post']."' method='POST'>";
		print "<p>Comment as: <b>".$_SESSION['username']."</b></p>";
		print "<textarea name='comment' rows='10' cols='85'></textarea>";
		print "<button type='submit' >Send</button>";
		print "</form>";
}


print "</p>";

print "</div>";
?>