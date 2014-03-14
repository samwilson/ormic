<div class="container-fluid">
	<?= $nav->render() ?>

	<ul>
		<?php foreach ($model->table_columns() as $col => $details): ?>
			<li>
				<strong><?= Arr::get($model->labels(), $col) ?>:</strong>
				<?= $model->$col ?>
			</li>
		<?php endforeach ?>
	</ul>

	<?php foreach ($model->has_many() as $alias=>$details): ?>
	<h2><?=Text::titlecase($alias)?></h2>
	<table class="table">
		<thead>
			<tr>
				<?php foreach ($model->$alias->find()->table_columns() as $col=>$details): ?>
				<td><?=Text::titlecase($col)?></td>
				<?php endforeach ?>
			</tr>
		</thead>
		<?php foreach ($model->$alias->find_all() as $rel): ?>
		<tr>
			<?php foreach ($rel->table_columns() as $col=>$details): ?>
			<td><?=$rel->$col?></td>
			<?php endforeach ?>
		</tr>
		<?php endforeach ?>
	</table>
	<?php endforeach ?>

</div>
