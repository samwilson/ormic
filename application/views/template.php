<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php if (isset($title)) echo "$title :: " ?><?= SITE_TITLE ?></title>

		<?= HTML::style('resources/css/bootstrap.min.css') ?>
		<?= HTML::style('resources/css/bootstrap-theme.min.css') ?>
		<?= HTML::style('vendor/eternicode/bootstrap-datepicker/css/datepicker3.css') ?>
	</head>
	<body class="">

		<?=View::factory('navbar')->render()?>

		<?php if (isset($alerts)): ?>
			<div class="container">
				<?php foreach ($alerts as $alert): ?>
					<div class="alert alert-<?= $alert['type'] ?>">
						<?= $alert['message'] ?>
					</div>
				<?php endforeach ?>
			</div>
		<?php endif ?>

		<?php if (isset($content)) echo $content ?>

		<?php if (Kohana::$environment==Kohana::DEVELOPMENT AND PHP_SAPI != 'cli'): ?>
			<div id="kohana-profiler">
				<?php echo View::factory('profiler/stats') ?>
			</div>
		<?php endif ?>

		<?= HTML::script('resources/js/jquery.min.js') ?>
		<?= HTML::script('resources/js/bootstrap.min.js') ?>
		<?= HTML::script('vendor/eternicode/bootstrap-datepicker/js/bootstrap-datepicker.js') ?>
		<?= HTML::script('resources/js/offline-forms.js') ?>
		<?= HTML::script('resources/js/application.js') ?>
	</body>
</html>
