<?php

namespace Ormic\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use View;

abstract class Controller extends BaseController {

	use DispatchesCommands,
	 ValidatesRequests;

	/** @var string */
	protected $currentAction;

	/** @var \Illuminate\View\View */
	protected $view;

	public function __construct() {
		$this->currentAction = array_get(explode('@', \Route::currentRouteAction()), 1, '');
		View::share('site_title', \Config::get('app.site_title'));
		View::share('title', ucwords($this->currentAction));
		View::share('alerts', \Session::get('alerts', array()));
		View::share('menu', $this->getMenu());
		View::share('logged_in', \Auth::check());
		View::share('user', \Auth::user());

		// Standard views are at:
		// resources/views/<controller_name>/<action_name>.blade.php
		$controllerPath = explode('\\', get_called_class());
		$controllerName = substr(array_pop($controllerPath), 0, -(strlen('Controller')));
		$viewName = ($controllerPath[1] == 'Modules') ? $controllerPath[2] . '::' : '';
		$viewName .= snake_case($controllerName) . '.' . $this->currentAction;
		try {
			$this->view = view($viewName);
		} catch (\InvalidArgumentException $ex) {
			// No view file found.
			$this->view = new \Illuminate\Support\Facades\View();
		}
	}

	private function getMenu() {
		$out = array();
		$fs = new \Illuminate\Filesystem\Filesystem();
		$pattern = app_path() . '/../modules/*/resources/menu.php';
		$menuFiles = $fs->glob($pattern);
		foreach ($menuFiles as $menuFile) {
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
	protected function alert($type, $message, $flash = false) {
		$alert = array('type' => $type, 'message' => $message);
		if ($flash) {
			\Session::flash('alert', $alert);
		}
		$alerts = \View::shared('alerts', array());
		$alerts[] = $alert;
		\View::share('alerts', $alerts);
	}

}
