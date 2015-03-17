<?php namespace Ormic\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
          'Illuminate\Contracts\Auth\Registrar', 'Ormic\Services\Registrar'
        );

        $modules = new \Ormic\Modules();
        foreach ($modules->getAll() as $name => $path) {
            $modServiceProvider = 'Ormic\\modules\\' . $name . '\\Providers\\' . studly_case($name) . 'ServiceProvider';
            if (class_exists($modServiceProvider)) {
                $this->app->register($modServiceProvider);
            }

            $viewDir = app_path() . '/../' . $path . '/resources/views';
            $this->loadViewsFrom($viewDir, snake_case($name));
        }
    }
}
