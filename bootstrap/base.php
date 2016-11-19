<?php


	  $root = 'http://'.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'],"",str_replace(DIRECTORY_SEPARATOR,"/",getcwd()))."/";

	  DEFINE ('BASE_URL',$root);


  ?>