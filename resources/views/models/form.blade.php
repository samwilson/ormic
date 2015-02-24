@extends('app')

@section('content')

@include('models.subnav', ['modelSlug'=>$modelSlug, 'active'=>$active])

<form action="<?= url('') ?>" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<?php foreach ($attributes as $attr): ?>

		<div class="row full-width">
			<div class="medium-2 column">
				<label class="inline" for="<?= $attr ?>">
					<?= titlecase(($rel = $record->getRelation($attr)) ? $rel : $attr) ?>
				</label>
			</div>
			<div class="medium-6 column">
				<?php if ($rel = $record->getRelation($attr)): ?>
					TODO
				<?php else: ?>
					<input type="text" name="title" id="title" value="<?= $record->$attr ?>" />
				<?php endif ?>

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
