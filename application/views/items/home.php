<div class="container-fluid">
	<h1>
		Items
		<a href="<?= Route::url('item/new') ?>" class="btn btn-default">Add new</a>
	</h1>

	<table class="table table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($assets as $item): ?>
				<tr>
					<td><?= $item->id ?></td>
					<td>
						<a href="<?= Route::url('item/edit', array('id' => $item->id)) ?>" title="Edit this record">
							<span class="glyphicon glyphicon-edit"></span>
						</a>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<div id="map"></div>
</div>
