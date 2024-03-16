<html>
<head>
	<?php Website::define_base(); ?>
	<title><?= Website::$_REQUESTED_PAGE->name ." | ". Website::$_SETTINGS->title ?></title>
	<meta charset="utf-8">
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<?php
		if(!empty(Website::$_SETTINGS->favicon)){
			Html::favicon(asset("storage/images/favicons/".Website::$_SETTINGS->favicon)); 
		}else{ 
			Html::favicon(asset(Website::$_THEME_PATH."/images/favicon.png")); 
		}
	?>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" id="hemingway-rewritten-fonts-css" href="https://fonts.googleapis.com/css?family=Raleway%3A400%2C300%2C700%7CLato%3A400%2C700%2C400italic%2C700italic&amp;subset=latin%2Clatin-ext" type="text/css" media="all">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


	<?php 
		if(method_exists('Website','customStyle')){
			echo Website::customStyle(); 
		}
	?>

	<!-- \App\Libs\PluginManager::render('OpenGraph'); -->
</head>

<body style="background-color:rgba(0,0,0,0.1);font-family:Lato;">