<html>
<head>
	<title>Website Down</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body style='overflow:hidden;'>

<section class='jumbotron' style='height:100%;'> 
<center>
<div class='row'>
	<?= Html::img(Website::logo(),"style='width:18%;'"); ?><br><br><br>
	<h4><?= $_SERVER['HTTP_HOST'] ?></h4>
</div>

<h2>The website is not available right now! <br> I guess they're developing something cool to you!</h2>



</center>
</section>

</body>
</html>