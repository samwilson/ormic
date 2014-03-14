<div class="container">

	<?php if (empty($models)): ?>
		<p class="alert alert-success">No models found.</p>
	<?php endif ?>

	<div class="list-group">
		<?php foreach ($models as $model => $count): ?>
		<a href="<?=Route::url('ormic', array('type'=>$model))?>" class="list-group-item">
			<span class="badge"><?=$count?></span>
			<?=$model?>
		</a>
		<?php endforeach ?>
	</div>

</div>
