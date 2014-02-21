<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Users extends Controller_Base {

	public function action_login()
	{
		$this->template->title = 'Log In';

		$username = $this->request->post('username');
		$password = $this->request->post('password');
		$return_to = $this->request->query('return_to');
		if ($this->request->post())
		{
			Auth::instance()->login($username, $password);
			if (Auth::instance()->logged_in())
			{
				// Make sure $return_to is a local URL
				$return = parse_url(urldecode($return_to));
				$to = Arr::get($return, 'path', '/') . '?' . Arr::get($return, 'query', '');
				$this->redirect($to);
			}
			else
			{
				$this->alert('Authentication Failed');
			}
		}

		// Bind view variables
		$this->view->username = $username;
		$this->view->password = '';
		$this->view->return_to = $return_to;
	}

	public function action_logout()
	{
		Auth::instance()->logout();
		$this->alert('You have been logged out.', 'success', TRUE);
		$this->redirect('login');
	}

	public function action_profile()
	{
		$this->view->user = $this->request->param('id');
		$this->view->roles = Auth::instance()->get_roles($this->view->user);
	}

}
