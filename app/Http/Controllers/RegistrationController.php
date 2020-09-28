<?php

namespace App\Http\Controllers;
use App\User;
use App\Environment;
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

        if (!$verify_token) {
            Log::error("Could not insert user into database!");
            return $this->api_response('Interval server error in DB insert', 500);
        }

        if (!$this->fire_email_verification($verify_token, Request::get('email'))) {
            Log::error("Could not fire email with verification link!");
            User::delete_last_user();
            return $this->api_response('Internal server error in mailer script', 500);
        }

        Log::info("Successfully registered user " . Request::get('user'));
        return $this->api_response('Successfully registered user', 200);
    }

    private function fire_email_verification($token, $email) {
        $mailer_key = Environment::get_env('MAILER_KEY');
        $mailer_key_header = Environment::get_env('MAILER_KEY_HEADER');

        if ($mailer_key == null || $mailer_key_header == null) {
            Log::error("Could not get mailer keys from key file!");
            return false;
        }

        $callback = "https://oviattassistant.com/verify_email?token=";
        $endpoint = "https://api.xdmtk.org/mailer/index.php?";
        $url_request = $endpoint .
            "&to=" . $email .
            "&token=" . $token .
            "&callback=" . $callback .
            "&key=" . Environment::get_env('MAILER_KEY');


        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, $url_request);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'API_KEY: ' . Environment::get_env('MAILER_KEY_HEADER'),
        ));
        curl_exec($curl);
    }
}
