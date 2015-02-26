<?php

namespace Ormic\Http\Controllers;

use Ormic\Model\User;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::all();
        return \View::make('users.index')->with('users', $users);
    }

    public function show($id)
    {
        
    }

    public function admin()
    {
        $view = view('users.admin');
        
        return $view;
    }

    public function getLogin(\Illuminate\Http\Request $request)
    {
        $view = view('users.login');
        $view->title = 'Log in';
        $view->adldap_suffix = \Config::get('adldap.account_suffix');
        return $view;
    }

    public function postLogin(\Illuminate\Http\Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // First try to log in as a local user.
        if (\Auth::attempt(array('username' => $username, 'password' => $password))) {
            return redirect()->action('HomeController@getIndex');
        }

        // Then try with ADLDAP.
        $ldapConfig = \Config::get('adldap');
        if (array_get($ldapConfig, 'domain_controllers', false)) {
            $adldap = new \adldap\adLDAP($ldapConfig);
            if ($adldap->authenticate($username, $password)) {
                // Check that they exist.
                $user = \Ormic\Model\User::where('username', '=', $username)->first();
                if (!$user) {
                    $user = new \Ormic\Model\User();
                    $user->username = $username;
                    $user->save();
                }
                \Auth::login($user);
                //$this->alert('success', 'You are now logged in.', TRUE);
                return redirect(''); //->with(['You are now logged in.']);
            }
        }

        // If we're still here, authentication has failed.
        return redirect()->back()
            ->withInput($request->only('username'))
            ->withErrors(['Authentication failed.']);
    }

    public function getLogout()
    {
        \Auth::logout();
        return redirect('');
    }

    public function getRegister()
    {
        $view = view('users.register');
        $view->title = 'Register';
        return $view;
    }
}
