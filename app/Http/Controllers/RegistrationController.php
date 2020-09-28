<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Request;

class RegistrationController extends Controller {

    public function register() {

        if (!(
            Request::has('username') &&
            Request::has('password') &&
            Request::has('email'))) {
            return $this->api_response('Missing username/password or email', 400);
        }

        if (User::user_exists(Request::get('username'))) {
            return $this->api_response('Username already exists!', 400);
        }
        if (User::email_exists(Request::get('email'))) {
            return $this->api_response('Email already exists!', 400);
        }

        $verify_token = User::create_user([
            'username' => Request::get('username'),
            'password' => Request::get('password'),
            'email' => Request::get('email'),
        ]);


    }

}
