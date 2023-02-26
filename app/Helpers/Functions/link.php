<?php 

function plugin_link($link,$param = null){

	$link = \Config::get('horizontcms.backend_prefix')."/plugin/run/".$link;

	return isset($param)? $link."/".$param : $link;

}


function namespace_to_slug($string){
	return ltrim(strtolower(preg_replace('/(?<!\ )[A-Z]/', '-$0', $string)),"-");
}