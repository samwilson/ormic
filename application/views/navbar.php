<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?= URL::base() ?>" class="navbar-brand"><?= SITE_TITLE ?></a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><?= HTML::anchor('items', 'Items') ?></li>
				<li><?= HTML::anchor('records', 'Records') ?></li>
			</ul>
			<form class="navbar-form navbar-right" role="search" action="<?= Route::url('search') ?>" method="get">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Global search">
				</div>
				<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle glyphicon glyphicon-user" data-toggle="dropdown"></a>
					<ul class="dropdown-menu">
						<?php if (Auth::instance()->logged_in()): ?>
							<li>
								<a href="<?= URL::site('users/profile/' . Auth::instance()->get_user()) ?>">
									Profile for <?= Auth::instance()->get_user() ?>
								</a>
							</li>
							<li>
								<a href="<?= Route::url('logout') ?>" title="Log Out">Log Out</a>
							</li>
						<?php else: ?>
							<li>
								<a href="<?= Route::url('login') ?>" title="Log In">
									<span class="glyphicon glyphicon-log-in"></span> Log In
								</a>
							</li>
						<?php endif ?>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle glyphicon glyphicon-cog" data-toggle="dropdown"></a>
					<ul class="dropdown-menu">
						<li>
							<a href="https://github.com/samwilson/ItemDB/issues" target="_blank">
								<span class="text-danger">Report an issue</span>
							</a>
						</li>
						<?php if (file_exists(DOCROOT . '/tests/index.html')): ?>
							<li>
								<a href="<?= URL::site('/tests/index.html') ?>" target="_blank">Status of tests</a>
							</li>
						<?php endif ?>
						<li>
							<a href="<?= URL::site('admin') ?>">
								Administration
							</a>
						</li>
					</ul>
				</li>

			</ul>
		</div>
	</div>
</nav>