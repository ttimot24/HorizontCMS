<?php

/**
* @theme: Twenty-Ten
* @author: Timot Tarjani
* @version: 1.7
*
*/


echo "<div class='header_image'>";
	$header_images = System::get_header_images();
		echo Html::img("images/header_images/".$header_images[0],"style='width:100%;'");
echo "</div>";


	
require(Website::$_THEME_PATH."/sitelinks.php");

	echo "<div class='content'>
		<div class='content-left'>";

		Website::handle_routing();


	echo "</div>
		<div class='content-right'>";
			require(Website::$_THEME_PATH."/sidebar.php");
	echo "</div>
	</div>";


?>