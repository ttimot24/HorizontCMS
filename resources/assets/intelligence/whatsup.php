<?php

require("../../core/config.php");


$time = time();
$intervall = 7;


$mysqli = new MySqli(SERVER,USERNAME,PASSWORD,DATABASE);





$result = $mysqli->query("SELECT * FROM ".PREFIX."user ORDER BY id DESC LIMIT 1");

$result = $result->fetch_array();

if(($time - $result['reg_date'] <= $intervall)){
	print "<b>New user: </b></br> <a href='admin/user/view/".$result['id']."'>" .$result['username'] ."</a></br>";
}




$result = $mysqli->query("SELECT * FROM ".PREFIX."blogpost ORDER BY id DESC LIMIT 1");

$result = $result->fetch_array();


if(($time - $result['date'] <= $intervall)){
	print "<b>New post: </b></br> 
	<a href='admin/blogpost/view/".$result['id']."'> " .$result['title'] ."</a>";
}



$result = $mysqli->query("SELECT * FROM ".PREFIX."blogpost_comment ORDER BY id DESC LIMIT 1");

$row = mysqli_fetch_array($result);


$news = $mysqli->query("SELECT * FROM ".PREFIX."blogpost WHERE id=".$row['news_id']."");
@$news = mysqli_fetch_array($news);

if(($time - $row['comment_date'] <= $intervall)){
print "<b>New comment on: </b></br> <a href='admin/blogpost/view/".$news['id']."#comments'> " .$news['title'] ."</a></br>";
}


$result->free_result();
$mysqli->close();

?>