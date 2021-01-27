<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {

    /**
     * Main page view controller function. Serves a static page for now
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home() {
        return view('home.layout', [
           'isMobile' => $this->agent->isMobile()
        ]);
    }

}
