<?php

Route::get('', 'HomeController@index');

Route::controllers([
	'user' => 'UsersController',
]);
Route::resource('asset', 'AssetsController');
Route::resource('job', 'JobsController');
Route::resource('task', 'TasksController');

/*
  Verb			Path						Action		Route Name

  GET			/resource					index		resource.index
  GET			/resource/create			create		resource.create
  POST			/resource					store		resource.store
  GET			/resource/{resource}		show		resource.show
  GET			/resource/{resource}/edit 	edit		resource.edit
  PUT/PATCH 	/resource/{resource}		update		resource.update
  DELETE		/resource/{resource}		destroy 	resource.destroy
 */


//
//Event::listen('illuminate.query', function($sql, $bindings) {
//	foreach ($bindings as $i => $val) {
//		$bindings[$i] = "'$val'";
//	}
//	$sql_with_bindings = array_reduce($bindings, function ($result, $item) {
//		return substr_replace($result, $item, strpos($result, '?'), 1);
//	}, $sql);
//	Log::info($sql_with_bindings);
//});
