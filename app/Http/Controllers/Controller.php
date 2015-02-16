<?php

namespace Amsys\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands,
	 ValidatesRequests;

	public function __construct() {
		\View::share('site_title', \Config::get('app.site_title'));
		\View::share('title', ucwords(array_get(explode('@', \Route::currentRouteAction()), 1, '')));
		\View::share('alerts', \Session::get('alerts', array()));
		\View::share('logged_in', \Auth::check());
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
