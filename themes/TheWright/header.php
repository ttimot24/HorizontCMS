<html>
<head>
	<?php Website::define_base(); ?>
	<title><?= Website::$_REQUESTED_PAGE->name ." | ". Website::$_SETTINGS->title ?></title>
	<meta charset="utf-8">
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<?php
		if(Website::$_SETTINGS->favicon!=""){
			Html::favicon(asset("storage/images/favicons/".Website::$_SETTINGS->favicon)); 
		}else{ 
			Html::favicon(asset(Website::$_THEME_PATH."/images/favicon.png")); 
		}
	?>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" id="hemingway-rewritten-fonts-css" href="https://fonts.googleapis.com/css?family=Raleway%3A400%2C300%2C700%7CLato%3A400%2C700%2C400italic%2C700italic&amp;subset=latin%2Clatin-ext" type="text/css" media="all">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


	<?php 
		if(method_exists('Website','customStyle')){
			Website::customStyle(); 
		}
	?>

	<!-- \App\Libs\PluginManager::render('OpenGraph'); -->
</head>

<body style="background-color:rgba(0,0,0,0.1);font-family:Lato;">