<?php

Route::set('login', 'login')->defaults(array(
	'controller' => 'users',
	'action' => 'login',
));
Route::set('logout', 'logout')->defaults(array(
	'controller' => 'users',
	'action' => 'logout',
));
Route::set('manifest', 'manifest')->defaults(array(
	'controller' => 'resources',
	'action' => 'manifest',
));
Route::set('home', '')->defaults(array(
	'controller' => 'home',
	'action' => 'home',
));
Route::set('ormic/view', '<type>/<id>', array(
	'id' => '[0-9]+'
))->defaults(array(
	'controller' => 'ormic',
	'action' => 'view',
));
Route::set('ormic', '<type>(/<id>)(/<action>)', array(
	'id' => '[0-9]+'
))->defaults(array(
	'controller' => 'ormic',
	'action' => 'index',
));

Route::set('default', '(<controller>(/<action>(/<id>)))')->defaults(array(
	'controller' => 'dashboard',
	'action' => 'home',
));
