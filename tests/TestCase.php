<?php namespace Ormic\Tests;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        return $app;
    }

    public function setUp()
    {
        parent::setUp();
        \Artisan::call('upgrade');
    }

    public function tearDown()
    {
        \DB::disconnect();
        parent::tearDown();
    }

    /**
     * A convienient way to get a new User object, for whatever tests need it.
     * @return \Ormic\Model\User The 'testuser' user.
     */
    public function getTestUser()
    {
        $user = \Ormic\Model\User::find(1);
        if (!$user) {
            $user = new \Ormic\Model\User();
            $user->name = 'Test User';
            $user->username = 'testuser';
            $user->email = 'test@example.org';
            $user->save();
        }
        return $user;
    }
}
