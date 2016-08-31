<div class="container main-container">

<h1><?= $this->language['settings']; ?></h1>
<br>
<br>
<br>

<div class="container col-md-12">

<?php foreach($data['panels'] as $each): ?>

<a href='<?= $each['link'] ?>'>
	<div class='well col-md-3'>

			<center>
				<i class="<?= $each['icon'] ?>" style='font-size:60px;'></i>
				<h4><?= $each['name'] ?></h4>
			</center>

	</div>	
</a>

<?php endforeach; ?>

</div>

</div>
<br><br>