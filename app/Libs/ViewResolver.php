<?php

namespace App\Libs;

use Config;

/**
 * @deprecated deprecated since version 1.0.0
 */
class ViewResolver
{

	public $data = [];

	public function __construct()
	{
		$this->data['title'] = null;
		$this->data['css'] = Config::get('horizontcms.css');
		$this->data['js'] = Config::get('horizontcms.js');
	}

	public function title($title)
	{
		$this->data['title'] = $title;
	}

	public function render($view_file, array $data = [])
	{

		return view($view_file, array_merge($this->data, $data));
	}


	public function css($file)
	{
		$this->data['css'][] = $file;
	}


	public function js($file)
	{
		$this->data['js'][] = $file;
	}
	
}
