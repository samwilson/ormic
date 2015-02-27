<?php namespace Ormic\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\View;

abstract class Controller extends BaseController {

    use DispatchesCommands,
        ValidatesRequests;

    /** @var string */
    protected $currentAction;

    /** @var \Illuminate\View\View */
    protected $view;

    /** @var array|string SQL queries that have been executed. */
    private static $queries = array();

    /** @var \Ormic\Model\User */
    protected $user;

    public function __construct()
    {
        $this->currentAction = array_get(explode('@', \Route::currentRouteAction()), 1, '');
        View::share('site_title', \Config::get('app.site_title'));
        View::share('title', ucwords($this->currentAction));
        View::share('alerts', \Session::get('alerts', array()));
        View::share('menu', $this->getMenu());
        View::share('logged_in', \Auth::check());
        $this->user = (\Auth::check()) ? \Auth::user() : new \Ormic\Model\User();
        View::share('user', $this->user);

        // Standard views are at:
        // resources/views/<controller_name>/<action_name>.blade.php
        $controllerPath = explode('\\', get_called_class());
        $controllerName = substr(array_pop($controllerPath), 0, -(strlen('Controller')));
        $viewName = ($controllerPath[1] == 'Modules') ? $controllerPath[2] . '::' : '';
        $viewName .= snake_case($controllerName) . '.' . $this->currentAction;
        try
        {
            $this->view = view($viewName);
        } catch (\InvalidArgumentException $ex)
        {
            // No view file found.
            $this->view = new \Illuminate\Support\Facades\View();
        }

        $this->queryListener();
    }

    private function queryListener()
    {
        View::share('queries', self::$queries);
        \Illuminate\Support\Facades\Event::listen('illuminate.query', function($sql, $bindings) {
            foreach ($bindings as $i => $val)
            {
                $bindings[$i] = "'$val'";
            }
            $sql_with_bindings = array_reduce($bindings, function ($result, $item) {
                return substr_replace($result, $item, strpos($result, '?'), 1);
            }, $sql);
            self::$queries[] = $sql_with_bindings;
            View::share('queries', self::$queries);
            \Illuminate\Support\Facades\Log::info($sql_with_bindings);
        });
    }

    private function getMenu()
    {
        $out = array();
        $fs = new \Illuminate\Filesystem\Filesystem();
        $pattern = app_path() . '/../modules/*/resources/menu.php';
        $menuFiles = $fs->glob($pattern);
        foreach ($menuFiles as $menuFile)
        {
            $menu = include $menuFile;
            $out = array_merge($out, $menu);
        }
        return $out;
    }

    /**
     * One of:
     *   secondary
     *   alert
     *   info
     *   warning
     *   success
     *
     * @param type $type
     * @param type $message
     * @param type $flash
     */
    protected function alert($type, $message, $flash = false)
    {
        $alert = array('type' => $type, 'message' => $message);
        if ($flash)
        {
            \Session::flash('alert', $alert);
        }
        $alerts = \View::shared('alerts', array());
        $alerts[] = $alert;
        \View::share('alerts', $alerts);
    }

}
