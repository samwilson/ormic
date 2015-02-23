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
						<h1><a href="<?= url('/') ?>"><?= $site_title ?></a></h1>
					</li>
				</ul>

				<section class="top-bar-section">
					<!-- Right Nav Section -->
					<ul class="right">
						@if ($logged_in)
						<li>
							<a href="<?= url('user/' . $user->username) ?>">You are logged in as {{$user->name}}</a>
						</li>
						<li><a href="<?= url('logout') ?>">Log out</a></li>
						@else
						<li><a href="<?= url('login') ?>">Log in</a></li>
						@endif
					</ul>

					<!-- Left Nav Section -->
					<ul class="left">
						<?php foreach ($menu as $menuItem): ?>
							<li <?php if (isset($menuItem['items'])) echo 'class="has-dropdown"' ?>>
								<a href="<?= $menuItem['href'] ?>"
								   <?php if (isset($menuItem['title'])) echo 'title="' . $menuItem['title'] . '"' ?>>
									   <?= $menuItem['text'] ?>
								</a>
								<?php if (isset($menuItem['items'])): ?>
									<ul class="dropdown">
										<?php foreach ($menuItem['items'] as $subItem): ?>
											<li>
												<a href="<?= $subItem['href'] ?>"
												   <?php if (isset($subItem['title'])) echo 'title="' . $subItem['title'] . '"' ?>>
													   <?= $subItem['text'] ?>
												</a>
											</li>
										<?php endforeach ?>
									</ul>
								<?php endif ?>
							</li>
						<?php endforeach ?>
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
