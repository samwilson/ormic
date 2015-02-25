@extends('app')

@section('content')

@include('models.subnav', ['modelSlug'=>$modelSlug, 'active'=>'view'])

@include('models.attribute_table', ['attributes'=>$attributes, 'record'=>$record])

<?php foreach ($record->getHasOne() as $oneName => $oneClass): ?>
	<?php if ($record->$oneName): ?>

		@include('models.attribute_table', [
		'attributes' => $$oneName->getAttributeNames(),
		'record' => $record->$oneName,
		'caption' => titlecase($oneName),
		])

	<?php endif ?>
<?php endforeach ?>

@stop
