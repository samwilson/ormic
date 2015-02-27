@extends('app')

@section('content')

@include('models.subnav', ['modelSlug'=>$modelSlug, 'active'=>$active])

<form action="<?= url($action) ?>" method="post" data-abide class="model-form">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <?php foreach ($columns as $column): ?>

        <div class="row full-width <?php if ($column->isRequired()) echo 'required' ?>">
            <div class="medium-2 column">
                <label class="inline" for="<?= $column ?>">
                    <?= titlecase(($rel = $record->getRelation($column)) ? $rel : $column) ?>
                    <?php if ($column->isRequired()): ?>
                    <abbr class="required" title="This field is required">&star;</abbr>
                    <?php endif ?>
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
                        <?php if ($column->isRequired()) echo 'required' ?>
                           value="{{$record->$column or old($column->getName())}}"
                           />
                <?php endif ?>

                    @if ($column->isRequired())
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
