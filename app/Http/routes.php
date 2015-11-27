<?php
Route::get('', 'Http\Controllers\HomeController@index');
// Users
Route::get('login', 'Http\Controllers\UsersController@getLogin');
Route::post('login', 'Http\Controllers\UsersController@postLogin');
Route::get('logout', 'Http\Controllers\UsersController@getLogout');
Route::get('register', 'Http\Controllers\UsersController@getRegister');
Route::post('register', 'Http\Controllers\UsersController@postRegister');
Route::get('admin/users', 'Http\Controllers\UsersController@admin');

/**
 * Module module routes.
 */
$mods = new \Ormic\Modules();
foreach ($mods->getModels() as $className => $moduleName) {
    // Ignore various model classes.
    if (in_array($className, array('Datalog', 'Column', 'Base'))) {
        continue;
    }

    $plural = str_plural($className);
    if ($moduleName) {
        $controllerClass = 'modules\\' . $moduleName . '\Http\Controllers\\' . $plural . 'Controller';
    } else {
        $controllerClass = 'Http\Controllers\\' . $plural . 'Controller';
    }
    if (!class_exists('Ormic\\' . $controllerClass)) {
        $controllerClass = 'Http\Controllers\ModelsController';
    }
    $slug = str_slug(snake_case($plural, ' '));
    Route::get("$slug", $controllerClass . '@index');
    Route::get("$slug/new", $controllerClass . '@form');
    Route::get("$slug/{id}", $controllerClass . '@view')->where(['id' => '[0-9]+']);
    Route::get("$slug/{id}/edit", $controllerClass . '@form');
    Route::post("$slug/new", $controllerClass . '@save');
    Route::post("$slug/{id}", $controllerClass . '@save');
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
