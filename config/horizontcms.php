<?php

return [

	'version' => 'v1.2.0',

	'installed' => env('INSTALLED', false),

	'backend_prefix' => env('HCMS_ADMIN_PREFIX','admin'),

	'charset' => 'utf-8',

	'default_controller' => 'login',

	'admin_logo' => 'resources/logo.png',
	
	'default_date_format' => 'Y.m.d H:i:s',

	'sattelite_url' => env('HCMS_CENTRAL_REPO','http://eterfesztival.hu/hcms_online_store/satellite/public/api'),

	'css' => [
				'resources/public/horizontcms-next.css',
			],

	'js' => [
				'resources/public/app.js',
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
