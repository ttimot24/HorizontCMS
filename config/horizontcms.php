<?php

return [

	'version' => '1.0.0-alpha.6',

	'backend_prefix' => env('HCMS_ADMIN_PREFIX','admin'),

	'charset' => 'utf-8',

	'default_controller' => 'login',

	'admin_logo' => 'resources/logo.png',

	'sattelite_url' => env('HCMS_CENTRAL_REPO','http://eterfesztival.hu/hcms_online_store/satellite/public/api'),

	'css' => [
			'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
			//'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css',

			//'resources/css/darktheme.css',
			//'resources/css/united.css',
			//'resources/css/flaty.css',
			//'resources/css/simplex.css',
			//'resources/css/culean.css',
			//'resources/css/superhero.css',
		   'resources/css/horizontcms.css',


			//'resources/css/default/style.css',
			//'resources/css/default/bootstrap_common.css',
			'resources/assets/filemaster/css/fileinput.min.css',
			'resources/assets/checkboxmaster/build.css',
			//'resources/assets/scrollbar/jquery.scrollbar.css',
			'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css'
			],

	'js' => [
			'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js',
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
			'resources/assets/filemaster/js/fileinput.js',
			'https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.0/vue.min.js',
			'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js',
			//'resources/assets/js/app.js',
			//'resources/js/app.js' //compiled
			//'resources/assets/nicescroll/jquery.nicescroll.min.js',
			//'resources/assets/scrollbar/jquery.scrollbar.js',
			//'https://cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js'
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