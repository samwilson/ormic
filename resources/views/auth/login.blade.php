@extends('app')

@section('content')

@if (count($errors) > 0)
<div class="alert">
	<strong>Whoops!</strong> There were some problems with your input.<br><br>
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<form method="POST" action="<?php //action('AuthController@postLogin')  ?>">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="row">
		<div class="medium-2 columns">
			<label class="right inline" for="username">Username:</label>
		</div>
		<div class="medium-5 columns">
			<input type="text" name="username" value="<?= $username ?>" class="focus-me" />
		</div>
		<div class="medium-5 columns">

		</div>
	</div>
	<div class="row">
		<div class="medium-2 columns">
			<label class="right inline" for="password">Password:</label>
		</div>
		<div class="medium-5 columns">
			<input type="password" name="password" id="password" />
		</div>
		<div class="medium-5 columns">
		</div>
	</div>
	<div class="row">
		<div class="medium-2 columns">
			<input type="checkbox" name="remember"> Remember Me
		</div>
		<div class="medium-5 columns">
			<input type="submit" class="button" value="Log in" />
		</div>
		<div class="medium-5 columns"></div>
	</div>
</form>

@endsection
