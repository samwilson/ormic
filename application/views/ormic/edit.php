<div class="container-fluid">
	<?=$nav->render()?>

	<form action="<?= Route::url('ormic', array('type'=>$object_name, 'id' => $model->id, 'action'=>'edit')) ?>"
		  role="form" method="post" class="ormic-edit-form" data-type="<?=$object_name?>">

		<?php foreach ($cols as $col=>$details): ?>
		<p class="form-group <?php if (Arr::get($errors, $col)) echo 'has-error' ?>">
			<label for="<?=$col?>"><?=Arr::get($labels,$col)?>:</label>

			<?php
			$help = '';
			$attrs = array('class'=>'form-control', 'id'=>$col);
			if (Arr::get($details, 'data_type') == 'date')
			{
				$attrs['type'] = 'date';
				$attrs['data-provide'] = 'datepicker';
				$attrs['data-date-format'] = 'yyyy-mm-dd';
			}
			if (Arr::get($details, 'extra') == 'auto_increment')
			{
				$attrs['disabled'] = TRUE;
				$help = Kohana::message('ormic', 'is_auto_increment');
			}
			if ($fk = $model->related_model($col))
			{
				echo Form::select(Arr::get($details, 'column_name'), $fk->option_values(), $model->$col, $attrs);
			}
			else
			{
				echo Form::input(Arr::get($details, 'column_name'), $model->$col, $attrs);
			}
			?>

			<span class="help-block">
				<?php if(!empty($help)) echo "$help<br />" ?>
				<?=Arr::get($errors, $col, '')?>
			</span>
		</p>
		<?php endforeach ?>

		<p class="form-group">
			<?= Form::submit('save', 'Save', array('class' => 'btn btn-primary', 'role' => 'button', 'tabindex' => 3)) ?>
			<?php $url = ($model->loaded())
					? Route::url('ormic/view', array('type'=>$object_name, 'id'=>$model->pk()))
					: Route::url('ormic', array('type'=>$object_name));
			?>
			<a href="<?=$url?>" class="btn btn-default" role="button">
				Cancel
			</a>
		</p>

	</form>

	<?= $datalog ?>
</div>
