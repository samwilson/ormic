<?php

//Route::get('', 'Http\Controllers\HomeController@index');

// Users
Route::get('login', 'Http\Controllers\UsersController@getLogin');
Route::post('login', 'Http\Controllers\UsersController@postLogin');
Route::get('logout', 'Http\Controllers\UsersController@getLogout');
//Route::get('register', 'Http\Controllers\UsersController@getRegister');
//Route::post('register', 'Http\Controllers\UsersController@postRegister');

Route::get('{model}', 'Http\Controllers\ModelsController@index');
Route::get('{model}/new', 'Http\Controllers\ModelsController@form');
Route::get('{model}/{id}', 'Http\Controllers\ModelsController@view');
Route::get('{model}/{id}/edit', 'Http\Controllers\ModelsController@form');
Route::post('{model}/new', 'Http\Controllers\ModelsController@save');
Route::post('{model}/{id}', 'Http\Controllers\ModelsController@save');

/**
 * Module module routes.
 */
//$mods = new \Ormic\Modules();
//foreach ($mods->getModels() as $className => $moduleName) {
//	$plural = str_plural($className);
//	if ($moduleName) {
//		$controllerClass = 'Modules\\' . $moduleName . '\Http\Controllers\\' . $plural . 'Controller';
//		// If the module doesn't have a controller for that model, use the generic one.
//		if (!class_exists(''.$controllerClass)) {
//			$controllerClass = 'Http\Controllers\ModelController';
//		}
//	} else {
//		$controllerClass = 'Http\Controllers\\' . $plural . 'Controller';
//	}
//	var_dump($controllerClass);
//	Route::resource(snake_case($plural), $controllerClass);
//}

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



//Event::listen('illuminate.query', function($sql, $bindings) {
//	foreach ($bindings as $i => $val) {
//		$bindings[$i] = "'$val'";
//	}
//	$sql_with_bindings = array_reduce($bindings, function ($result, $item) {
//		return substr_replace($result, $item, strpos($result, '?'), 1);
//	}, $sql);
//	Log::info($sql_with_bindings);
//});
