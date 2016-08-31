<?php header('Content-Type: text/html; charset=' .$this->charset); ?>
<!DOCTYPE html>
<html>

<head>

	<base href="<?= BASE_DIR ?>" />

	<link rel="shortcut icon" type="image/png" href="storage/images/favicons/favicon16.png"/>
	<title><?= $this->title; ?> - HorizontCMS</title>


	<?php 

		foreach($this->meta as $meta) {
			echo Html::meta($meta['name'],$meta['content']);
		}

		foreach($this->css as $link) {
			echo Html::cssFile($link);
		}

		foreach($this->js as $link) {
			echo Html::jsFile($link);
		}

	?>

</head>

<?php 
if(file_exists("core/config.php")){
$_SYSTEM = new System();
echo "<body style='padding-top:4.4%;  background-image:url(" .$_SYSTEM->get_admin_background() ."); 	background-repeat: no-repeat;background-attachment: fixed; background-size:cover;'>";
}
else{
echo "<body style='padding-top:4.4%;'>";
}