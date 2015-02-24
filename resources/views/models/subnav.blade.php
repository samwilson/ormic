<dl class="sub-nav">
	<dd class="<?php if ($active == 'search') echo 'active' ?>">
		<a href="<?= url($modelSlug) ?>">Search</a>
	</dd>

	<dd class="<?php if ($active == 'create') echo 'active' ?>">
		<a href="<?= url($modelSlug . '/new') ?>">Create</a>
	</dd>

	<dd class="<?php if ($active == 'view') echo 'active' ?>">
		<a <?php if ($record) echo 'href="' . url($modelSlug . '/' . $record->id) . '"' ?>>
			View
		</a>
	</dd>

	<dd class="<?php if ($active == 'edit') echo 'active' ?>">
		<a <?php if ($record) echo 'href="' . url($modelSlug . '/' . $record->id . '/edit') . '"' ?>>
			Edit
		</a>
	</dd>

	<!--
	<dd class="{%if active=='export'%}active{%endif%}">
		<a href="<?= url($modelSlug . '/export') ?>">Export</a>
	</dd>

	<dd class="{%if active=='import'%}active{%endif%}">
		<a href="<?= url($modelSlug . '/import') ?>">Import</a>
	</dd>
	-->

</dl>

