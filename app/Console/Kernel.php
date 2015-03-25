<?php namespace Ormic\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Events\Dispatcher;

class Kernel extends \Illuminate\Foundation\Console\Kernel
{

    /** @var array List of Artisan commands. */
    protected $commands = [
        'Ormic\Console\Commands\Upgrade',
    ];

    public function __construct(Application $app, Dispatcher $events)
    {
        parent::__construct($app, $events);
        $fs = new Filesystem();
        $modules = new \Ormic\Modules();
        foreach ($modules->getAll() as $name => $path) {
            $commandsDir = app_path() . '/../' . $path . '/Console/Commands';
            $commandFiles = $fs->files($commandsDir);
            foreach ($commandFiles as $commandFile) {
                $command = substr(basename($commandFile), 0, -4);
                $this->commands[] = "Ormic\\modules\\$name\\Console\\Commands\\$command";
            }
        }
    }
}
