<div class="container-fluid">
	<h1>
		<?=Inflector::plural($object_name)?>
		<a href="<?= Route::url('ormic', array('type'=>$object_name,'action'=>'edit')) ?>" class="btn btn-default">Add new</a>
	</h1>

	<?php if (count($models)==0):?>
	<div class="container">
		<p class="alert alert-success">No records found.</p>
	</div>

	<?php else: ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<?php foreach ($cols as $col=>$details): ?>
				<th><?=Arr::Get($labels,$col)?></th>
				<?php endforeach ?>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($models as $model): ?>
				<tr>
					<?php foreach ($cols as $col=>$details): ?>
					<td><?=$model->$col?></td>
					<?php endforeach ?>
					<td>
						<a href="<?= Route::url('ormic', array('id' => $model->id, 'type'=>$object_name, 'action'=>'edit')) ?>"
						   title="View this record">
							<span class="glyphicon glyphicon-record"></span>
						</a>
						<a href="<?= Route::url('ormic', array('id' => $model->id, 'type'=>$object_name, 'action'=>'edit')) ?>"
						   title="Edit this record">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>

</div>
