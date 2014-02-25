<div class="container-fluid">

	<h1><?=$object_name?> #<?=$model->id?></h1>

	<p><a href="<?=Route::url('ormic',array('type'=>$object_name))?>">Back to list</a></p>

	<ul>
		<?php foreach ($cols as $col=>$details): ?>
		<li>
			<strong><?=Text::titlecase($col)?>:</strong> <?=$model->$col?>
		</li>
		<?php endforeach ?>
	</ul>

</div>
