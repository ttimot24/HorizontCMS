<?php 

$array = [
	'blogpost_index' => '',
	'blogbost_new' => '',
	'blogpost_edit' => '',
	'blogpost_delete' => '',

];


foreach ($array as &$value) {
    $value = Config::get('horizontcms.backend_prefix').$value;
}
unset($value);

return $array;