<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller {


    public function login_blade() {
        return view('login');

    }

    /**
     * Attempt to login with the supplied username/password combo. Redirect to
     * admin on success for now (only admins are users currently, this will probably change)
     * @param Request $request
     */
    public function login(Request $request) {
        if (Auth::attempt($request->only('username', 'password'))) {
            return redirect('/admin');
        }
        Log::debug("Failed login");
        return redirect('/');
    }

    /**
     * Logs the user out if they are logged in. Redirects to /admin on successful logout
     * @param Request $request
     */
    public function logout(Request $request) {
        if (Auth::user()) {
            Auth::logout();
            if (strpos(Redirect::back(), 'admin') !== false) {
                return redirect('/admin');
            }
            else {
                return Redirect::back();
            }
        }
        return Redirect::back();
    }
}
