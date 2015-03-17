@extends('app')

@section('content')

@include('models.subnav', ['modelSlug'=>$modelSlug, 'active'=>'search'])

@if ($records->total()==0)
<p class="alert-box info">No records found.</p>

@else
<table>
    <caption><?= number_format($records->total()) ?> records found.</caption>
    <thead>
        <tr>
            <th colspan="2"><em>Actions</em></th>
            <?php foreach ($columns as $column): ?>
                <th>
                    <?php
                    if ($rel = $record->getRelation($column))
                        echo titlecase($rel);
                    else
                        echo titlecase($column);
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
                <a 
                @if ($record->canEdit())
                href="<?= url($modelSlug . '/' . $record->id . '/edit') ?>"
                @else
                class="disabled"
                @endif
                >Edit</a>
            </td>
            <?php foreach ($columns as $column): ?>
                <td>
                    <?php if ($rel = $record->getRelation($column)): ?>
                        <a href="<?= $record->$rel->getUrl() ?>">
                            <?= $record->getAttributeTitle($column) ?>
                        </a>
                    <?php else: ?>
                        <?= $record->$column ?>
                    <?php endif ?>
                </td>
            <?php endforeach ?>
        </tr>
        @endforeach
    </tbody>
</table>

@include('models.pagination', ['paginator'=>$records])

@endif

@stop
