<?php

	if(php_sapi_name()!="cli"){

	  $root = 'http://'.$_SERVER['HTTP_HOST'];

	  //$_SERVER['DOCUMENT_ROOT'] = str_replace(DIRECTORY_SEPARATOR,"/",$_SERVER['DOCUMENT_ROOT']);

	  $path = str_replace($_SERVER['DOCUMENT_ROOT'],"",str_replace(DIRECTORY_SEPARATOR,"/",getcwd()))."/";

	  if($path[0] != "/"){
	  	$root .= "/";
	  }

	  $root .= $path;


	  DEFINE ('BASE_URL',$root);

	}else{
	  DEFINE ('BASE_URL',"");	
	}


  ?>