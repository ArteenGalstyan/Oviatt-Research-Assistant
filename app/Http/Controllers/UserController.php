<?php

namespace App\Http\Controllers;
use App\User;
use App\Environment;
use Illuminate\Support\Facades\Request;
use Log;

class UserController extends Controller {

    public function profile_blade() {
       return view('profile.layout');
    }

}
