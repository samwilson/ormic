@extends('app')

@section('content')

@include('models.subnav', ['modelSlug'=>$modelSlug, 'active'=>$active])

<form action="<?= url($action) ?>" method="post" data-abide>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <?php foreach ($columns as $column): ?>

        <div class="row full-width">
            <div class="medium-2 column">
                <label class="inline" for="<?= $column ?>">
                    <?= titlecase(($rel = $record->getRelation($column)) ? $rel : $column) ?>
                </label>
            </div>

            <div class="medium-6 column">
                <?php if ($rel = $record->getRelation($column)): ?>
                    <?php /* <select name="<?= $attr ?>">
                      <?php foreach ($record->$rel->all() as $f): ?>
                      <option vallue=""><?= $f->getTitle() ?></option>
                      <?php endforeach ?>
                      </select> */ ?>
                <?php else: ?>
                    <input type="text" name="<?= $column ?>" id="title"
                    <?php if (!$column->nullable()) echo 'required' ?>
                           value="<?= $record->$column ?>"
                           />
                <?php endif ?>

                    @if (!$column->nullable())
                    <small class="error">This field is required.</small>
                    @endif
            </div>

            <div class="medium-4 column">
            </div>
        </div>

    <?php endforeach ?>

    <div class="row full-width">
        <div class="medium-6 column medium-offset-2">
            <input type="submit" value="Save" class="button success" />
        </div>
    </div>
</form>

@stop
