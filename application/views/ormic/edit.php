<div class="container-fluid">
	<?=$nav->render()?>

	<form action="<?= Route::url('ormic', array('type'=>$object_name, 'id' => $model->id, 'action'=>'edit')) ?>" role="form" method="post">

		<?php foreach ($cols as $col=>$details): ?>
		<p class="form-group <?php if (Arr::get($errors, $col)) echo 'has-error' ?>">
			<label for="<?=$col?>"><?=Arr::get($labels,$col)?>:</label>

			<?php
			$help = '';
			$attrs = array('class'=>'form-control', 'id'=>$col);
			if ($details['data_type']=='date')
			{
				$attrs['type'] = 'date';
				$attrs['data-provide'] = 'datepicker';
				$attrs['data-date-format'] = 'yyyy-mm-dd';
			}
			if ($details['extra']=='auto_increment')
			{
				$attrs['disabled'] = TRUE;
				$help = Kohana::message('ormic', 'is_auto_increment');
			}
			if ($fk = $model->related_model($col))
			{
				echo Form::select($details['column_name'], $fk->option_values(), $model->$col, $attrs);
			}
			else
			{
				echo Form::input($details['column_name'], $model->$col, $attrs);
			}
			?>

			<span class="help-block">
				<?php if(!empty($help)) echo "$help<br />" ?>
				<?=Arr::get($errors, $col, '')?>
			</span>
		</p>
		<?php endforeach ?>

		<?php if ($model->loaded()): ?>
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
		<?php endif ?>

		<p class="form-group">
			<?= Form::submit('save', 'Save', array('class' => 'btn btn-primary', 'role' => 'button', 'tabindex' => 3)) ?>
			<a href="<?= Route::url('ormic', array('type'=>$object_name)) ?>" class="btn btn-default" role="button" title="Return to item list" tabindex="4">Cancel</a>
		</p>

	</form>

	<?= $datalog ?>
</div>
