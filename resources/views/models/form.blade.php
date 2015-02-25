@extends('app')

@section('content')

@include('models.subnav', ['modelSlug'=>$modelSlug, 'active'=>$active])

<form action="<?= url($action) ?>" method="post">
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
					<?php /* <select name="<?= $attr ?>">
						<?php foreach ($record->$rel->all() as $f): ?>
							<option vallue=""><?= $f->getTitle() ?></option>
						<?php endforeach ?>
					</select> */ ?>
				<?php else: ?>
					<input type="text" name="<?= $attr ?>" id="title" value="<?= $record->$attr ?>" />
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
