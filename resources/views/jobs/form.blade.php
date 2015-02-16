@extends('app')

@section('content')

<form action="<?= route('job.store') ?>" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="row">
		<div class="medium-2 column">
			<label class="inline right" for="asset">Asset</label>
		</div>
		<div class="medium-6 column">
			<input type="hidden" name="asset_id" id="asset" value="{{$asset->id}}" />
			<input type="text" name="asset" id="asset" value="{{$asset->title}}" readonly />
		</div>
		<div class="medium-4 column">
			<label>To add a Job to a different Asset, navigate from that Asset's details page.</label>
		</div>
	</div>

	<div class="row">
		<div class="medium-2 column">
			<label class="inline right" for="job_type_id">Type</label>
		</div>
		<div class="medium-6 column">
			<select name="job_type_id" id="job_type">
				@foreach ($job_types as $type)
				<option value="{{$type->id}}">{{$type->title}}</option>
				@endforeach
			</select>
		</div>
		<div class="medium-4 column">
		</div>
	</div>

	<div class="row">
		<div class="medium-6 column medium-offset-2">
			<input type="submit" value="Save" class="button success" />
			<a href="<?= route('asset.show', [$asset->id]) ?>" class="button">Cancel</a>
		</div>
	</div>
</form>

@stop
