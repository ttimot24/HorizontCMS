<?php

	if(php_sapi_name()!="cli"){

	  $root = 'http://'.$_SERVER['HTTP_HOST'].DIRECTORY_SEPARATOR.str_replace($_SERVER['DOCUMENT_ROOT'],"",str_replace(DIRECTORY_SEPARATOR,"/",getcwd()))."/";

	  DEFINE ('BASE_URL',$root);
	}else{
	  DEFINE ('BASE_URL',"");	
	}


  ?>