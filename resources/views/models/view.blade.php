@extends('app')

@section('content')

@include('models.subnav', ['modelSlug'=>$modelSlug, 'active'=>'view'])

@include('models.attribute_table', ['columns'=>$columns, 'record'=>$record])

<?php foreach ($record->getHasOne() as $oneName => $oneClass): ?>
	<?php if ($record->$oneName): ?>

		@include('models.attribute_table', [
		'columns' => $$oneName->getColumns(),
		'record' => $record->$oneName,
		'caption' => titlecase($oneName),
		])

	<?php endif ?>
<?php endforeach ?>

<h2>Datalog</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Date and time</th>
            <th>User</th>
            <th>Field</th>
            <th>Old value</th>
            <th></th>
            <th>New value</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datalog as $datum)
        <tr>
            <td>{{$datum->id}}</td>
            <td>{{$datum->date_and_time}}</td>
            <td>{{$datum->user->name}}</td>
            <td>{{titlecase($datum->field)}}</td>
            <td>{{$datum->old_value}}</td>
            <td>&rArr;</td>
            <td>{{$datum->new_value}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
