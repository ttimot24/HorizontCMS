<?php

	  $document_root = str_replace("/",DIRECTORY_SEPARATOR,$_SERVER['DOCUMENT_ROOT']);

	  $root = DIRECTORY_SEPARATOR.ltrim(str_replace($document_root,"",getcwd()),DIRECTORY_SEPARATOR);


	  $root==DIRECTORY_SEPARATOR? : $root .= DIRECTORY_SEPARATOR;


	  DEFINE ('BASE_DIR',$root);


  ?>