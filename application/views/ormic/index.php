<div class="container-fluid">
	<?=$nav->render()?>

	<?php if (count($models)==0):?>
	<div class="container">
		<p class="alert alert-success">No records found.</p>
	</div>

	<?php else: ?>
	<?=$pagination?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th></th>
				<?php foreach ($cols as $col=>$details): ?>
				<th><?=Arr::Get($labels,$col)?></th>
				<?php endforeach ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($models as $model): ?>
				<tr>
					<td>
						<a href="<?= Route::url('ormic', array('id' => $model->id, 'type'=>$type, 'action'=>'view')) ?>"
						   title="View this record">
							<span class="glyphicon glyphicon-record"></span>
						</a>
						<a href="<?= Route::url('ormic', array('id' => $model->id, 'type'=>$type, 'action'=>'edit')) ?>"
						   title="Edit this record">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</td>
					<?php foreach ($cols as $col=>$details): ?>
					<td>
						<?php
						if ($rel = $model->get_belongsto_by_fk($col)) {
							if ($model->$rel->loaded()) {
								$uri = Route::get('ormic/view')->uri(array('type'=>$model->$rel->object_name(), 'id'=>$model->$col));
								echo HTML::anchor($uri, $model->$rel->candidate_key());
							}
						} else {
							echo $model->$col;
						}
						?>
					</td>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>

</div>
