<div class="container">
	<h1>Administration</h1>

	<h2>
		Asset Owners
		<a href="<?= URL::site('admin/owner') ?>" class="btn btn-default" role="button">Add New</a>
	</h2>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th></th>
			</tr>
		</thead>
		<?php foreach ($owners as $owner): ?>
			<tr>
				<td><?= $owner->id ?></td>
				<td><?= $owner->name ?></td>
				<td>
					<a href="<?= URL::site('admin/owner/' . $owner->id) ?>" title="Edit this record">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>

	<h2>
		Asset Types
		<a href="<?= URL::site('admin/type') ?>" class="btn btn-default" role="button">Add New</a>
	</h2>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th></th>
			</tr>
		</thead>
		<?php foreach ($types as $type): ?>
			<tr>
				<td><?= $type->id ?></td>
				<td><?= $type->name ?></td>
				<td>
					<a href="<?= URL::site('admin/type/' . $type->id) ?>" title="Edit this record">
						<span class="glyphicon glyphicon-edit"></span>
					</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>

</div>
