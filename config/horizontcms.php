<?php

return[

	'version' => '0.8.5',

	'backend_prefix' => env('HCMS_ADMIN_PREFIX','admin'),

	'charset' => 'utf-8',

	'default_controller' => 'login',

	'admin_logo' => 'resources/logo.png',

	'sattelite_url' => 'http://www.eterfesztival.hu',

	'css' => [
			'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
			//'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css',

			//'resources/css/darktheme.css',
			//'resources/css/united.css',
			//'resources/css/flaty.css',
			//'resources/css/simplex.css',
			//'resources/css/culean.css',
			//'resources/css/superhero.css',
		   'resources/css/timot.css',


			//'resources/css/default/style.css',
			//'resources/css/default/bootstrap_common.css',
			'resources/assets/filemaster/css/fileinput.min.css',
			'resources\assets\checkboxmaster\build.css',
			//'resources/assets/scrollbar/jquery.scrollbar.css',
			],

	'js' => [
			'https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js',
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
			'resources/assets/filemaster/js/fileinput.js',
			'resources/assets/nicescroll/jquery.nicescroll.min.js',
			//'resources/assets/intelligence/AjaxFramework.js',
			//'resources/scripts/main-script.js',
			//'resources/assets/scrollbar/jquery.scrollbar.js',
		],

	'meta' =>[
				[ "name" => "viewport", 
				   "content" => "width=device-width, initial-scale=1.0"
				],

			],



];