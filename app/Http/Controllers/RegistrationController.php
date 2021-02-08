<?php

namespace App\Http\Controllers;
use App\User;
use App\Environment;
use Illuminate\Support\Facades\Request;
use Log;

class RegistrationController extends Controller {

    /**
     * Registration API entry point. Checks for user details and attempts to
     * write the user into the database as an unverified user. A verification email
     * is sent to the user with a link to verify their account.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register() {
        Log::debug("In route /register");

        // Check for required params
        if (!(
            Request::has('username') &&
            Request::has('password') &&
            Request::has('email'))) {

            Log::error("Request to register() did not supply username/password/or email");
            return $this->api_response('Missing username/password or email', 400);
        }

        // Check if user already exists
        if (User::user_exists(Request::get('username'))) {
            Log::warning("Username trying to register already exists");
            return $this->api_response('Username already exists!', 400);
        }

        // Check if email already exists
        if (User::email_exists(Request::get('email'))) {
            Log::warning("Email trying to register already exists");
            return $this->api_response('Email already exists!', 400);
        }

        // Generate a unique token for the user to verify with
        $verify_token = User::create_user([
            'username' => Request::get('username'),
            'password' => Request::get('password'),
            'email' => Request::get('email'),
        ]);

        // Make sure the insert succeeded
        if (!$verify_token) {
            Log::error("Could not insert user into database!");
            return $this->api_response('Interval server error in DB insert', 500);
        }

        // Send user verification email with generated token
        if (!$this->fire_email_verification($verify_token, Request::get('email'))) {
            Log::error("Could not fire email with verification link!");
            User::delete_last_user();
            return $this->api_response('Internal server error in mailer script', 500);
        }

        Log::info("Successfully registered user " . Request::get('user'));
        return $this->api_response('Successfully registered user', 200);
    }


    /**
     * Entry point for registration verification API, triggered by the link sent
     * in the verification email. On success, switches the `verified` column in the
     * Database from 0 to 1
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify_email() {

        if (!(Request::has('email') && Request::has('token'))) {

            Log::error("Request to verify_email() did not supply token or email");
            return $this->api_response('Missing token or email', 400);
        }

        // Check for update success
        $verify_response = User::verify_user(Request::get('email'), Request::get('token'));
        if ($verify_response !== true) {
            Log::error("Couldn't verify user with email: " . Request::get('email'));
            return $this->api_response($verify_response[1], 400);
        }

        return $this->api_response("Successfully verified user", 200);
    }


    /**
     * View function for serving the static content in the verification blade
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verify_email_blade() {
        return view('static.verify_email');
    }


    /**
     * Triggers an external mailer service (xdmtk.org) to fire the
     * verification email for registration
     *
     * @param $token - Unique verification token generated for user
     * @param $email - Destination email
     * @return bool - Success or failure
     */
    private function fire_email_verification($token, $email) {
        $mailer_key = Environment::get_env('MAILER_KEY');
        $mailer_key_header = Environment::get_env('MAILER_KEY_HEADER');

        Log::debug("Got mailer key: " . $mailer_key);
        Log::debug("Got mailer key header: " . $mailer_key_header);

        // Get API keys for xdmtk mailer
        if ($mailer_key == null || $mailer_key_header == null) {
            Log::error("Could not get mailer keys from key file!");
            return false;
        }

        // Set verification link
        $callback = "https://oviattassistant.com/verify_email?";
        $endpoint = "https://api.xdmtk.org/mailer/index.php?";
        $url_request = $endpoint .
            "to=" . $email .
            "&token=" . $token .
            "&key=" . $mailer_key .
            "&callback=" . $callback;


        // Fire request
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
