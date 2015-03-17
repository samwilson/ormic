<?php namespace Ormic\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'event.name' => [
            'EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        // Register an observer on each model.
        $modules = new \Ormic\Modules();
        foreach ($modules->getModels(true) as $class => $model)
        {
            if (class_exists($class))
            {
                $classInfo = new \ReflectionClass($class);
                if (!$classInfo->isAbstract() && $classInfo->isSubclassOf('Ormic\Model\Base'))
                {
                    $class::observe(new \Ormic\Observers\Datalog());
                }
            }
        }
    }

}
