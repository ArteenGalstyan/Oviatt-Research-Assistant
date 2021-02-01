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
            return view('profile.layout');
        }
        return Redirect::to('/');
    }

}
