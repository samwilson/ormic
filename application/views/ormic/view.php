<div class="container-fluid">
	<?=$nav->render()?>

	<ul>
		<?php foreach ($model->table_columns() as $col=>$details): ?>
		<li>
			<strong><?=Arr::get($model->labels(),$col)?>:</strong> <?=$model->$col?>
		</li>
		<?php endforeach ?>
	</ul>

</div>
