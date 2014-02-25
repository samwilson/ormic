<ul class="nav nav-pills">
	<?php foreach ($actions as $a): ?>
	<li class="<?php if ($action==$a) echo 'active' ?>">
		<a href="<?=Route::url('ormic', array('action'=>$a, 'type'=>$type, 'id'=>$id))?>">
			<?php //Route::get('default')->//Request::current()->route()->?>
			<?=$a?>
		</a>
	</li>
	<?php endforeach ?>
</ul>
