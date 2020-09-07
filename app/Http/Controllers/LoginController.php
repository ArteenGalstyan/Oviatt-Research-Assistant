<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller {

    public function login(Request $request) {
        if (Auth::attempt($request->only('username', 'password'))) {
            return redirect('/admin');
        }
        Log::debug("Failed login");
        return redirect('/');
    }

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
