<?php

	  $document_root = str_replace(DIRECTORY_SEPARATOR,"/",$_SERVER['DOCUMENT_ROOT']);

	  $root = ltrim(str_replace($document_root,"",getcwd()),DIRECTORY_SEPARATOR);


	  $root==DIRECTORY_SEPARATOR? : $root .= DIRECTORY_SEPARATOR;


	  /*$root = str_replace("\\","/",getcwd());

	  $root = "http://localhost".str_replace($_SERVER['DOCUMENT_ROOT'], "", $root)."/";
*/

	  
	  DEFINE ('BASE_DIR',$root);





  ?>