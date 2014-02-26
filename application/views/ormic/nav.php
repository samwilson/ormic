<h1>
	<?=Kohana::message($model->object_name(), 'title_plural', Text::titlecase($model->table_name()))?>
</h1>
<p>
	<?=Kohana::message($model->object_name(), 'description')?>
</p>
<ul class="nav nav-tabs">
	<?php foreach ($actions as $action=>$a): ?>
	<li class="<?=Arr::get($a,'class')?> <?php if($action==$active)echo'active'?>">
		<a href="<?=Arr::get($a,'url')?>"><?=Arr::get($a,'title')?></a>
	</li>
	<?php endforeach ?>
</ul>
