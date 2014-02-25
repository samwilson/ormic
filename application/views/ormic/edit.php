<div class="container-fluid">
	<h1><?php echo ($model->loaded()) ? 'Editing '.$object_name.' #' . $model->id : 'New '.$object_name ?></h1>

	<form action="<?= Route::url('ormic', array('type'=>$object_name, 'id' => $model->id, 'action'=>'edit')) ?>" role="form" method="post">

		<?php foreach ($cols as $col=>$details): ?>
		<p class="form-group <?php if (Arr::get($errors, $col)) echo 'has-error' ?>">
			<label for="<?=$col?>"><?=Arr::get($labels,$col)?>:</label>
			<?php //echo debug::vars($details) ?>

			<?php
			$help = '';
			$attrs = array('class'=>'form-control', 'id'=>$col);
			if ($details['data_type']=='date') {
				$attrs['type'] = 'date';
				$attrs['data-provide'] = 'datepicker';
				$attrs['data-date-format'] = 'yyyy-mm-dd';
			}
			if ($details['extra']=='auto_increment') {
				$attrs['disabled'] = TRUE;
				$help = Kohana::message('ormic', 'is_auto_increment');
			}
			echo Form::input($details['column_name'], $model->$col, $attrs);
			?>

			<span class="help-block">
				<?=$help?>
				<?=Arr::get($errors, $col, '')?>
			</span>
		</p>
		<?php endforeach ?>

		<p class="form-group">
			<?= Form::submit('save', 'Save', array('class' => 'btn btn-primary', 'role' => 'button', 'tabindex' => 3)) ?>
			<a href="<?= Route::url('ormic', array('type'=>$object_name)) ?>" class="btn btn-default" role="button" title="Return to item list" tabindex="4">Cancel</a>
		</p>

	</form>

	<?= $datalog ?>
</div>
