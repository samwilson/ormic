@extends('app')

@section('content')

@include('models.subnav', ['modelSlug'=>$modelSlug, 'active'=>'search'])

<table>
    <caption><?=number_format($records->total())?> records found.</caption>
	<thead>
		<tr>
			<th colspan="2"><em>Actions</em></th>
			<?php foreach ($attributes as $attr): ?>
				<th>
					<?php
					if ($rel = $record->getRelation($attr))
						echo titlecase($rel);
					else
						echo titlecase($attr);
					?>
				</th>
			<?php endforeach ?>
		</tr>
	</thead>
	<tbody>
		@foreach($records as $record)
		<tr>
			<td>
				<a href="<?= url($modelSlug . '/' . $record->id) ?>">View</a>
			</td>
			<td>
				<a href="<?= url($modelSlug . '/' . $record->id . '/edit') ?>">Edit</a>
			</td>
			<?php foreach ($attributes as $attr): ?>
				<td>
					<?php if ($rel = $record->getRelation($attr)): ?>
						<a href="<?= $record->$rel->getUrl() ?>">
							<?= $record->getAttributeTitle($attr) ?>
						</a>
					<?php else: ?>
						<?= $record->$attr ?>
					<?php endif ?>
				</td>
			<?php endforeach ?>
		</tr>
		@endforeach
	</tbody>
</table>

@include('models.pagination', ['paginator'=>$records])

@stop
