<?php 

function admin_link($link){
	return \Config::get('horizontcms.backend_prefix')."/".$link;
}