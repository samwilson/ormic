@extends('app')

@section('content')

<form action="<?= route('asset.store') ?>" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="row">
		<div class="medium-3 column">
			<label class="inline right" for="title">Title</label>
		</div>
		<div class="medium-6 column">
			<input type="text" name="title" id="title" value="{{$asset->title}}" />
		</div>
		<div class="medium-3 column">
		</div>
	</div>

	<div class="row">
		<div class="medium-3 column">
			<label class="inline right" for="asset_type">Type</label>
		</div>
		<div class="medium-6 column">
			<select name="asset_type" id="asset_type">
				@foreach ($asset_types as $type)
				<option value="{{$type->id}}">{{$type->title}}</option>
				@endforeach
			</select>
		</div>
		<div class="medium-3 column">
		</div>
	</div>

	<div class="row">
		<div class="medium-6 column medium-offset-3">
			<input type="submit" value="Save" class="button success" />
		</div>
	</div>
</form>

@stop
