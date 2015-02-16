@extends('app')

@section('content')

<p><a href="<?= route('asset.edit', [$asset->id]) ?>" class="button tiny">Edit this Asset</a></p>

<h2>Jobs</h2>

@if ($asset->jobs->count() == 0)
<p class="alert-box info">There are no jobs associated with this Asset yet.</p>
@endif


@foreach ($asset->jobs as $job)
<div class="row">
	<div class="column medium-6">
		<dl>
			<dt>Job ID:</dt><dd>{{$job->id}}</dd>
			<dt>Tasks:</dt>
		</dl>
	</div>
	<div class="column medium-6">
		<table class="tasks">
			<thead>
				<tr>
					<th>Task ID</th>
					<th>Type</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

@endforeach

<p><a href="<?= route('job.create') ?>?asset={{$asset->id}}" class="button tiny">Add a new Job</a></p>

<div class="row">

</div>

@stop
