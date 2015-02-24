<?php

namespace Ormic\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'Ormic';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router) {
		parent::boot($router);
		$router->pattern('id', '[0-9]+');
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router) {

		// Module routes.
		$modules = new \Ormic\Modules();
		foreach ($modules->getAll() as $mod) {
			include app_path() . '/../' . $mod . '/Http/routes.php';
		}

		// Core application routes.
		$router->group(['namespace' => $this->namespace], function($router) {
			require app_path('Http/routes.php');
		});
	}

}
