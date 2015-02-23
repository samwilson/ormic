<?php

Route::get('', 'Http\Controllers\HomeController@index');

// Users
//Route::get('login', 'Http\Controllers\UsersController@getLogin');
//Route::post('login', 'Http\Controllers\UsersController@postLogin');
//Route::get('register', 'Http\Controllers\UsersController@getRegister');
//Route::post('register', 'Http\Controllers\UsersController@postRegister');

// Module module routes.
$mods = new \Amsys\Modules();
foreach ($mods->getModels() as $className => $moduleName) {
	$plural = str_plural($className);
	if ($moduleName) {
		Route::resource(snake_case($plural), 'Modules\\' . $moduleName . '\Http\Controllers\\' . $plural . 'Controller');
	} else {
		Route::resource(snake_case($plural), 'Http\Controllers\\' . $plural . 'Controller');
	}
}

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
