@extends('app')

@section('content')

<p><a href="<?= route('asset.edit', [$asset->id]) ?>" class="button tiny">Edit this Asset</a></p>

<h2>Jobs</h2>

@if ($asset->jobs->count() == 0)
<p class="alert-box info">There are no jobs associated with this Asset yet.</p>
@endif

<div class="row">

</div>

@stop
