<?php

class Controller_Resources extends Controller_Base {

	public function action_manifest()
	{
		
		$this->response->headers('content-type', 'text/cache-manifest');
		$this->template = View::factory('resources/manifest');
	}


}
