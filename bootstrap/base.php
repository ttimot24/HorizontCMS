<?php

	  $root = DIRECTORY_SEPARATOR.ltrim(str_replace($_SERVER['DOCUMENT_ROOT'],"",getcwd()),DIRECTORY_SEPARATOR);


	  $root==DIRECTORY_SEPARATOR? : $root .= DIRECTORY_SEPARATOR;


	  DEFINE ('BASE_DIR',$root);

  ?>