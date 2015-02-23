<?php

namespace Amsys\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register() {
		$this->app->bind(
		  'Illuminate\Contracts\Auth\Registrar', 'Amsys\Services\Registrar'
		);

		$mods = new \Amsys\Modules();
		$mods->register($this->app);
	}

}
