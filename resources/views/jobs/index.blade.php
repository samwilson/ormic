@extends('layout')

@section('content')

<?=Form::open()?>
<div class="row">
	<div class="medium-3 column">
		<label class="" for="asset_titles">Asset Titles</label>
		<?=Form::textarea('asset_titles', null, array('cols'=>20, 'rows'=>20))?>
	</div>
	<div class="medium-3 column">
		<label class="" for="job_statuses">Job Statuses</label>
		<?=Form::select('job_statuses')?>
	</div>
	<div class="medium-3 column">
		<input type="submit" value="Search" class="button success" />
	</div>
</div>
<?=Form::close()?>

@stop
