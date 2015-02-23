@extends('app')

@section('content')

<p>Welcome to {{$site_title}}.</p>

<ol>
	@foreach ($models as $model=>$module)
	<li>
		<a href="<?= url(snake_case(str_plural($model), '-')) ?>">
			<?= ucwords(snake_case(str_plural($model), ' ')) ?>
		</a>
	</li>
	@endforeach
</ol>

@endsection
