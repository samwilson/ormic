<?php

namespace Ormic\Console\Commands;

class Upgrade extends \Illuminate\Console\Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'upgrade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade Ormic.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->call('down');
        $this->info("Upgrading core application.");
        $this->call('migrate');
        $modules = new \Ormic\Modules();
        foreach ($modules->getAll() as $name => $path) {
            $this->info("Upgrading $name module.");
            $dbPath = $path . '/database/migrations';
            $this->call('migrate', array('--path' => $dbPath));
        }
        $this->call('up');
    }
}
