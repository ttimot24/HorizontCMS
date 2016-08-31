<?php

require_once("plugins/youtubevideos/model/Youtube.php");


echo "<div>";

if(!Youtube::is_installed()){
	echo Website::$message->error("YouTube plugin is not installed!");
}
else{
$videos = Youtube::get_all_video();


while($video = $videos->fetch()){
	echo "<h2>".$video['title']."</h2>";
	$youtube1 = explode("https://www.youtube.com/watch?v=",$video['link']);
	            echo '
              <iframe style="width:100%;height:70%;" src="http://www.youtube.com/embed/'.$youtube1[1] .'"></iframe>
<br>';

	echo "</br></br>";
}
}

echo "</div>";

?>