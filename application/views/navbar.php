<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapsible-navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?= URL::base() ?>" class="navbar-brand"><?= SITE_TITLE ?></a>
		</div>

		<div class="collapse navbar-collapse" id="collapsible-navbar">
			<ul class="nav navbar-nav">
				<?php foreach (Ormic::menu() as $title => $menu): ?>

					<?php if (is_array($menu)): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<?=$title?> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						<?php foreach ($menu as $uri=>$item): ?>
						<li>
							<a href="<?=URL::site($uri)?>" class="">
								<?=$item?>
							</a>
						</li>
						<?php endforeach ?>
						</ul>
					</li>
					<?php else: ?>
					<li><a href="<?=$menu?>"><?=$menu?></a></li>
					<?php endif ?>

				<?php endforeach ?>
			</ul>

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
							<a href="<?= URL::site('help') ?>">Help</a>
						</li>
						<li>
							<a href="https://github.com/samwilson/ItemDB/issues" target="_blank">
								<span class="text-danger">Report an issue</span>
							</a>
						</li>
						<?php if (file_exists(DOCROOT . '/tests/testdox.html')): ?>
							<li>
								<a href="<?= URL::site('/tests/testdox.html') ?>" target="_blank">Test Dox</a>
							</li>
						<?php endif ?>
					</ul>
				</li>

			</ul>
		</div>
	</div>
</nav>