@extends('app')

@section('content')

<form action="">
	<div class="row">
		<div class="medium-3 column">
		</div>
	</div>
</form>

<table>
	@foreach ($assets as $asset)
	<tr>
		<td><a href="{{route('asset.show', $asset->id)}}">{{$asset->status()}}</a></td>
		<td>{{$asset->id}}</td>
		<td>{{$asset->title}}</td>
		<td>{{$asset->status()}}</td>
	</tr>
	@endforeach
</table>

@stop
