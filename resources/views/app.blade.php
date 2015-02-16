<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>{{$title}} :: {{$site_title}}</title>
		<link href="<?= asset('css/foundation.min.css') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= asset('css/all.css') ?>" rel="stylesheet" type="text/css" />
		<script src="<?= asset('js/modernizr.js') ?>"></script>

	</head>
	<body>
		<header>
			<nav class="top-bar" data-topbar>
				<ul class="title-area">
					<li class="name"> 
						<h1><a href="<?= action('HomeController@index') ?>"><?= $site_title ?></a></h1>
					</li>
				</ul>

				<section class="top-bar-section">
					<!-- Right Nav Section -->
					<ul class="right">
						<li>
							@if ($logged_in)
							<a href="<?= action('UsersController@getLogout') ?>">Log out</a>
							@else
							<a href="<?= action('UsersController@getLogin') ?>">Log in</a>
							@endif
						</li>
					</ul>

					<!-- Left Nav Section -->
					<ul class="left">
						<li class="has-dropdown">
							<a href="<?= action('AssetsController@index') ?>" title="Search">Assets</a>
							<ul class="dropdown">
								<li><a href="<?= action('AssetsController@create') ?>">Create</a></li>
							</ul>
						</li>
						<li class="has-dropdown">
							<a href="<?= action('JobsController@index') ?>">Jobs</a>
							<ul class="dropdown">
								<li><a href="<?= action('JobsController@create') ?>">Create</a></li>
							</ul>
						</li>
						<li class="has-dropdown">
							<a href="<?= action('TasksController@index') ?>">Tasks</a>
							<ul class="dropdown">
								<li><a href="<?= action('TasksController@create') ?>">Create</a></li>
							</ul>
						</li>
					</ul>
				</section>
			</nav>
		</header>

		<div id="content">
			<h1>
				{{$title}}
				@if (isset($subtitle))
				<small>{{$subtitle}}</small>
				@endif
			</h1>

			@foreach ($alerts as $alert)
			<div data-alert class="alert-box <?= $alert['type'] ?>">
				<?= $alert['message'] ?>
				<a href="#" class="close">&times;</a>
			</div>
			@endforeach

			@foreach ($errors->all() as $error)
			<div data-alert class="alert-box warning row">
				{{ $error }}
				<a href="#" class="close">&times;</a>
			</div>
			@endforeach

			@yield('content')

		</div>

		<footer class="top-bar">
			<section class="top-bar-section">
				<!-- Right Nav Section -->
				<ul class="right">
					<li>
						<a href="{{config('app.homepage')}}">
							{{config('app.name')}} {{config('app.version')}}
						</a>
					</li>
				</ul>
			</section>
		</footer>

		<script src="<?= asset('js/jquery.js') ?>"></script>
		<script src="<?= asset('js/foundation.min.js') ?>"></script>
		<script src="<?= asset('js/app.js') ?>"></script>
		<script>$(document).foundation();</script>
	</body>
</html>
