<?php

namespace Amsys\Http\Controllers;

class UsersController extends Controller {

	public function index() {
		$users = User::all();
		return \View::make('users')->with('users', $users);
	}

	public function getLogin(\Illuminate\Http\Request $request) {
		return view('users.login')
			->with('title', 'Log in')
			->with('adldap_suffix', \Config::get('adldap.account_suffix'));
	}

	public function postLogin(\Illuminate\Http\Request $request) {
		$username = $request->input('username');
		$password = $request->input('password');
		$adldap = new \adldap\adLDAP(\Config::get('adldap'));

		// First try to log in as a local user.
		if (\Auth::attempt(array('username' => $username, 'password' => $password))) {
			return redirect()->action('HomeController@getIndex');
		}

		// Then try with ADLDAP.
		if ($adldap->authenticate($username, $password)) {
			// Check that they exist.
			$user = \Amsys\User::where('username', '=', $username)->first();
			if (!$user) {
				$user = new \Amsys\User();
				$user->username = $username;
				$user->save();
			}
			\Auth::login($user);
			//$this->alert('success', 'You are now logged in.', TRUE);
			return redirect(''); //->with(['You are now logged in.']);
		}

		// If we're still here, authentication has failed.
		return redirect()->back()
			->withInput($request->only('username'))
			->withErrors(['Authentication failed.']);
	}

	public function getLogout() {
		\Auth::logout();
		//$this->alert('success', 'You are now logged out.');
		return redirect('');
	}

}
