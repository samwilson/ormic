<div class="container">
	<h1>
		Type
		<small><?php echo ($type->loaded()) ? 'Edit' : 'New' ?></small>
	</h1>

	<form action="<?= URL::site('admin/type/' . $type->id) ?>" role="form" method="post">
		<p class="form-group <?php if (Arr::get($errors, 'name')) echo 'has-error' ?>">
			<label for="name" class="control-label">Name:</label>
			<?= Form::input('name', $type->name, array('class' => 'form-control initial-focus')) ?>
			<?php if (Arr::get($errors, 'name')): ?>
				<span class="help-block"><?= Arr::get($errors, 'name') ?></span>
			<?php endif ?>
		</p>
		<p class="form-group">
			<?= Form::submit(NULL, 'Save', array('class' => 'btn btn-primary', 'role' => 'button')) ?>
			<a href="<?= URL::site('clients') ?>" class="btn btn-default" role="button" title="Return to Client list">Cancel</a>
		</p>
	</form>

	<?= $datalog ?>
</div>
