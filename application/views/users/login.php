<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2>Log In</h2>
			<form action="<?php echo Route::url('login') . URL::query() ?>" method="post" class="login-form" role="form">
				<p class="form-group">
					<?php echo Form::label('username', 'Username:') ?>
					<?php echo Form::input('username', $username, array('class' => 'form-control initial-focus', 'tabindex'=>1)) ?>
				</p>
				<p class="form-group">
					<?php echo Form::label('password', 'Password:') ?>
					<?php echo Form::password('password', $password, array('class' => 'form-control', 'tabindex'=>2)) ?>
				</p>
				<p class="form-group">
					<?php echo Form::submit('login', 'Log in', array('class' => 'btn btn-default', 'tabindex'=>3)) ?>
				</p>
				<p class="help-note">
					If you have any problems, please read the
					<?php echo HTML::anchor('docs', 'user manual') ?>,<br />
					and if that doesn't work,
					<?php echo HTML::anchor('https://github.com/samwilson/ItemDB/issues', 'log an issue') ?>.
				</p>
			</form>
		</div>
	</div>
</div>
