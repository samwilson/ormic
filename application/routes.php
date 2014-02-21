<?php

Route::set('login', 'login')->defaults(array(
	'controller' => 'users',
	'action' => 'login',
));
Route::set('logout', 'logout')->defaults(array(
	'controller' => 'users',
	'action' => 'logout',
));
Route::set('items', 'items')->defaults(array(
	'controller' => 'items',
	'action' => 'home',
));
Route::set('item/edit', '(<id>/)edit')->defaults(array(
	'controller' => 'items',
	'action' => 'edit',
));
Route::set('item/new', 'new')->defaults(array(
	'controller' => 'items',
	'action' => 'edit',
));
Route::set('search', 'search(/<term>)')->defaults(array(
	'controller' => 'search',
	'action' => 'home',
));
Route::set('default', '(<controller>(/<action>(/<id>)))')->defaults(array(
	'controller' => 'dashboard',
	'action' => 'home',
));
