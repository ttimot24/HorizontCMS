<?php

if($_SESSION['lock']==1){
	$_SESSION['lock']=0;
}
else if($_SESSION['lock']==0){
	$_SESSION['lock']=1;
}


?>