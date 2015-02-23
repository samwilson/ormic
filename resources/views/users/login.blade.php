@extends('app')

@section('content')

<form action="<?= url('login') ?>" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="row">
		<div class="medium-2 columns">
			<label class="right inline" for="username">Username:</label>
		</div>
		<div class="medium-5 columns">
			<input type="text" name="username" value="{{ old('username') }}" id="username" class="focus-me" />
		</div>
		<div class="medium-5 columns">
			@if ($adldap_suffix)
			<label class="inline" for="username">{{$adldap_suffix}}</label>
			@endif
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
			&nbsp;
		</div>
		<div class="medium-5 columns">
			<input type="submit" class="button" value="Log in" />
			<a href="<?= url('register') ?>" class="button default">Register</a>
		</div>
		<div class="medium-5 columns"></div>
	</div>
</form>

@stop
