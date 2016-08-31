<?php 


class Template implements IViewInterface{


	public function render($theme,$data = null){

		if(file_exists("themes/" .$theme."/index.php")){
			!file_exists("themes/".$theme."/header.php")? :require("themes/".$theme."/header.php");
				require("themes/".$theme."/index.php");
			!file_exists("themes/".$theme."/footer.php")? :require("themes/".$theme."/footer.php");
		}
		else{
			echo "<b>HorizontCMS:</b> Can not render the theme!";
		}
	

	}











}