<?php
namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PHPUnit\Util\Json;

class LoginController extends Controller {

    /**
     * Attempt to login with the supplied username/password combo. Redirect to
     * admin on success for now (only admins are users currently, this will probably change)
     * @param Request $request
     * @return Json - JSON encoded response to caller
     */
    public function login(Request $request) {
        if (Auth::attempt($request->only('username', 'password'))) {

            if (!Auth::user()->verified) {
                Auth::logout();
                return $this->api_response('User not verified!', 400);
            }

            return $this->api_response('Login successful', 200);
        }
        Log::debug("Failed login");
        return $this->api_response('Login failed. Invalid username or password', 400);
    }

    /**
     * Logs the user out if they are logged in. Redirects to /admin on successful logout
     * @param Request $request
     * @return RedirectResponse - Redirects user to origin URL
     */
    public function logout(Request $request) {
        if (Auth::user()) {
            Auth::logout();
        }
        return Redirect::back();
    }
}
