<?php namespace Ormic\Http\Controllers;

use Ormic\Model\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function getLogin(\Illuminate\Http\Request $request)
    {
        $view = view('users.login');
        $view->title = 'Log in';
        if (!empty(\Config::get('adldap.domain_controllers'))) {
            $view->adldap_suffix = \Config::get('adldap.account_suffix');
        }
        $view->canRegister = User::canRegister();
        return $view;
    }

    public function postLogin(\Illuminate\Http\Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // First try to log in as a local user.
        if (Auth::attempt(array('username' => $username, 'password' => $password))) {
            $this->alert('success', 'You are now logged in.', true);
            return redirect('users/' . Auth::user()->id);
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

    public function postRegister()
    {
        if (Request::input('password') != Request::input('password_confirmation')) {
            throw new \Exception("Passwords do not match.");
        }
        $user = new User();
        $user->username = Request::input('username');
        $user->email = Request::input('email');
        $user->save();
        $password = new \Ormic\Model\UserPassword();
        $password->user_id = $user->id;
        $password->password = Hash::make(Request::input('username'));
        $password->save();
        $this->alert('success', 'Your account has been created.');
        return redirect('users/' . $user->id);
    }
}
