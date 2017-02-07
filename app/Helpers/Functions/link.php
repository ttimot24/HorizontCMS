<?php 

function admin_link($link,$param = null){

	$link = \Config::get('horizontcms.backend_prefix')."/".\Config::get('links.'.$link);

	return isset($param)? $link."/".$param : $link;
}


function plugin_link($link,$param = null){

	$link = \Config::get('horizontcms.backend_prefix')."/plugin/run/".$link;

	return isset($param)? $link."/".$param : $link;

}