<?php

return [

	'version' => '1.0.0-beta.4',

	'backend_prefix' => env('HCMS_ADMIN_PREFIX','admin'),

	'charset' => 'utf-8',

	'default_controller' => 'login',

	'admin_logo' => 'resources/logo.png',
	
	'default_date_format' => 'Y.m.d H:i:s',

	'sattelite_url' => env('HCMS_CENTRAL_REPO','http://eterfesztival.hu/hcms_online_store/satellite/public/api'),

	'css' => [
			'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',

			'resources/css/horizontcms-next.css',

			'resources/assets/filemaster/css/fileinput.min.css',
			'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css'
			],

	'js' => [
			'https://code.jquery.com/jquery-3.6.0.min.js',
			'resources/assets/filemaster/js/fileinput.min.js',
			'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js',
			'resources/js/app.js',
		],

	'meta' =>[
				[ "name" => "viewport", 
				   "content" => "width=device-width, initial-scale=1.0"
				],

			],

	'modules' => [ //namespaces and root dirs for modules
				'Theme' =>  'themes',
				'Plugin' => 'plugins',
			],



];
