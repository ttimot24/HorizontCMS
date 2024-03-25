<?php 

/**
 * @deprecated deprecated since version 1.0.0
 */
function plugin_link($link,$param = null){

	$link = config('horizontcms.backend_prefix')."/plugin/run/".$link;

	return isset($param)? $link."/".$param : $link;

}


function namespace_to_slug($string){
	return ltrim(strtolower(preg_replace('/(?<!\ )[A-Z]/', '-$0', $string)),"-");
}

/**
 * @deprecated deprecated since version 1.0.0
 */
function remove_linebreaks($string){
	return str_replace(["\n", "\\n", "\r\n","\\r\\n", "\r", "\\r"],"", $string);
}