<?php

namespace App\Http\Controllers;
use App\User;
use App\Environment;
use Illuminate\Support\Facades\Request;
use Auth;
use Log;
use Redirect;

class UserController extends Controller {

    public function profile_blade() {
        if (Auth::user() && Auth::user()->verified) {
            return view('profile.layout', [
                'username' => Auth::user()->username,
                'email' => Auth::user()->email
            ]);
        }
        return Redirect::to('/');


    }

    public function change_password($new_password) {
        if (Auth::user() && Request::has('new_password')) {
            $ret = User::update_password($new_password);
            return $this->api_response(
                $ret ? 'Successfully updated password' : 'Failed to update password',
                $ret ? 200 : 400
            );
        }
        return $this->api_response(
            'Must be logged in',
            400
        );
    }

}
