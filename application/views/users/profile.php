<div class="container">
	<h1>User profile for <tt><?= $user ?></tt></h1>
	<p>This user has the following roles:</p>
	<ul>
		<?php foreach ($roles as $role): ?>
			<li><?= $role ?></li>
		<?php endforeach ?>
	</ul>
</div>