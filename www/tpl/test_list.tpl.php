<div class="promo">
	<header>
		<h1>Добро пожаловать!</h1>
	</header>
	<article>
		<header>
			<p class="promo_big">Здесь вы можете пройти тесты на знание Symfony 3.4 и Symfony 2.6.</p>
		</header>
		<ul class="nomark p-0 cards">
			<?php foreach ($handler->aRows as $aRow): ?>
			<li class="card mb-5 bg-white"><a href="/tests/<?=$aRow['reading_uri']?>" target="_blank">
				<img src="<?=$aRow['bgimage']?>" width="200px" class="left mr-3 mb-3">
				<div class="mobreaker-l"></div>
				<h3><?=$aRow['display_name']?></h3><?=$aRow['description']?>
				<div class="clearfix"></div>
			</a></li>
			<?php endforeach ?>
		</ul>
		
	</article>
</div>
