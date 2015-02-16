<?php

namespace Amsys\Http\Controllers;

class HomeController extends Controller {

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index() {
		return \View::make('home')
		  ->with('title', 'Welcome');
	}

}
