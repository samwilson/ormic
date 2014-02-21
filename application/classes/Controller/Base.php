<?php

abstract class Controller_Base extends Controller_Template {

	/** @var string */
	private $alert_session_key = 'alerts';

	/** @var View */
	protected $view;

	public function before()
	{
		parent::before();

		// Set up template and view
		$controller = strtolower($this->request->controller());
		$action = strtolower($this->request->action());
		if (Kohana::find_file("views/$controller", $action))
		{
			$this->view = View::factory("$controller/$action");
		} else {
			throw new HTTP_Exception_500("Unable to load view: $controller/$action");
		}
		$this->template->content = $this->view;

		// Get postponed alerts
		$this->template->alerts = array();
		foreach (Session::instance()->get($this->alert_session_key, array()) as $alert)
		{
			$this->alert($alert['message'], $alert['type']);
		}
		Session::instance()->set($this->alert_session_key, array());

	}

	/**
	 * Add an alert to the page.
	 *
	 * See http://getbootstrap.com/components/#alerts
	 *
	 * @param string $type One of: success, info, warning, or danger
	 * @param string $message HTML message
	 * @param boolean $postpone Show on next page load
	 * @throws Exception If the type is wrong
	 */
	protected function alert($message, $type = 'info', $postpone = FALSE)
	{
		$valid_types = array('success', 'info', 'warning', 'danger');
		if ( ! in_array($type, $valid_types))
		{
			throw new Exception("'$type' is not a valid alert type");
		}
		$new_alert = array(
			'type' => $type,
			'message' => $message,
		);
		if ($postpone)
		{
			$alerts = Session::instance()->get($this->alert_session_key, array());
			$alerts[] = $new_alert;
			Session::instance()->set($this->alert_session_key, $alerts);
		} else {
			$this->template->alerts[] = $new_alert;
		}
	}

}
