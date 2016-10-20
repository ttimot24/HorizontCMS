<html>

<head>

	<?php //echo Website::define_base(); ?>
	<title><?= Website::$_SETTINGS->title ?>  |  <?= Website::$_SETTINGS->slogan ?></title>
	<link rel="stylesheet" type="text/css" href="<?= Website::$_THEME_PATH ?>/style.css">


</head>

<body>
		<header>
			<h1 style='width:75%;float:left;'><?= Website::$_SETTINGS->site_name ?></h1>
			<div class='slogan'></br><?= Website::$_SETTINGS->slogan ?></div>
		</header>
	</br>
