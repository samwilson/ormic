<div class="container">
	<h1><?php echo ($item->loaded()) ? 'Item #' . $item->id : 'New Item' ?></h1>

	<form action="<?= Route::url('item/edit', array('id' => $item->id)) ?>" role="form" method="post">

		<p class="form-group">
			<label for="id">ID:</label>
			<?= Form::input('id', $item->id, array('class' => 'form-control', 'id' => 'id', 'disabled')) ?>
			<?php if ( ! $item->loaded()): ?>
				<span class="help-block">Will be assigned automatically.</span>
			<?php endif ?>
		</p>

		<?php if (ItemDB::get_types()): ?>
			<?php foreach (ItemDB::get_types() as $type): ?>
				<fieldset>
					<legend><?= $type ?></legend>
					<?= View::factory("item/$type")
						->bind('errors', $errors)
						->bind('item', $item)
						->render() ?>
				</fieldset>
			<?php endforeach ?>
		<?php endif ?>

		<p class="form-group">
			<?= Form::submit('save', 'Save', array('class' => 'btn btn-primary', 'role' => 'button', 'tabindex' => 3)) ?>
			<a href="<?= Route::url('items') ?>" class="btn btn-default" role="button" title="Return to item list" tabindex="4">Cancel</a>
		</p>

	</form>

	<?= $datalog ?>
</div>
