@extends('app')

@section('content')

@include('models.subnav', ['modelSlug'=>$modelSlug, 'active'=>'view'])

<table>
	<?php foreach ($attributes as $attr): ?>
		<tr>
			<th class="right">
				<?= titlecase(($rel = $record->getRelation($attr)) ? $rel : $attr) ?>:
			</th>
			<td>
				<?php if ($rel = $record->getRelation($attr)): ?>
					<a href="<?= $record->$rel->getUrl() ?>">
						<?= $record->getAttributeTitle($attr) ?>
					</a>
				<?php else: ?>
					<?= $record->getAttributeTitle($attr) ?>
				<?php endif ?>
			</td>
		</tr>
	<?php endforeach ?>
</table>

@stop
