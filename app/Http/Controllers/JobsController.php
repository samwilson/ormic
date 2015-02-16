<?php

class JobsController extends BaseController {

	public function index() {
		$view = View::make('jobs/index');
		$view->title = 'Jobs';
		return $view;
	}

}
