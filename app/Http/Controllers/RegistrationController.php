<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Request;
use Log;

class RegistrationController extends Controller {

    public function register() {
        Log::debug("In route /register");
        if (!(
            Request::has('username') &&
            Request::has('password') &&
            Request::has('email'))) {

            Log::error("Request did not supply username/password/or email");
            return $this->api_response('Missing username/password or email', 400);
        }

        if (User::user_exists(Request::get('username'))) {
            Log::warning("Username trying to register already exists");
            return $this->api_response('Username already exists!', 400);
        }
        if (User::email_exists(Request::get('email'))) {
            Log::warning("Email trying to register already exists");
            return $this->api_response('Email already exists!', 400);
        }

        $verify_token = User::create_user([
            'username' => Request::get('username'),
            'password' => Request::get('password'),
            'email' => Request::get('email'),
        ]);
        $this->fire_email_verification($verify_token, Request::get('email'));

        Log::info("Successfully registered user " . Request::get('user'));
        return $this->$this->api_response('Successfully registered user', 200);
    }

    private function fire_email_verification($token, $email) {
        $callback = "https://oviattassistant.com/verify_email?token=";
        $endpoint = "https://api.xdmtk.org/mailer/index.php?";
        $url_request = $endpoint .
            "&to=" . $email .
            "&token=" . $token .
            "&callback=" . $callback .
            "&key=5f7131d0f30df5f7131d0f30e4";


        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, $url_request);
        curl_exec($curl);
    }
}
