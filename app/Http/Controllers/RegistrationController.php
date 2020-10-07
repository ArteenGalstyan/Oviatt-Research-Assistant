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

            Log::error("Request to register() did not supply username/password/or email");
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

    public function verify_email() {

        if (!(Request::has('email') && Request::has('token'))) {

            Log::error("Request to verify_email() did not supply token or email");
            return $this->api_response('Missing token or email', 400);
        }

        $verify_response = User::verify_user(Request::get('email'), Request::get('token'));
        if ($verify_response !== true) {
            Log::error("Couldn't verify user with email: " . Request::get('email'));
            return $this->api_response($verify_response[1], 400);
        }

        return $this->api_response("Successfully verified user", 200);
    }

    public function verify_email_blade() {
        return view('static.verify_email');
    }

    private function fire_email_verification($token, $email) {
        $mailer_key = Environment::get_env('MAILER_KEY');
        $mailer_key_header = Environment::get_env('MAILER_KEY_HEADER');

        Log::debug("Got mailer key: " . $mailer_key);
        Log::debug("Got mailer key header: " . $mailer_key_header);

        if ($mailer_key == null || $mailer_key_header == null) {
            Log::error("Could not get mailer keys from key file!");
            return false;
        }

        $callback = "https://oviattassistant.com/verify_email?";
        $endpoint = "https://api.xdmtk.org/mailer/index.php?";
        $url_request = $endpoint .
            "to=" . $email .
            "&token=" . $token .
            "&key=" . $mailer_key .
            "&callback=" . $callback;


        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, $url_request);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'API_KEY: ' . $mailer_key_header,
        ));


        Log::info("Firing curl request to endpoint:" . $url_request);
        if (curl_exec($curl) === false) {
            Log::error("Curl error: " . curl_error($curl));
            return false;
        }
        Log::info("Curl successful");
        return true;
    }
}
