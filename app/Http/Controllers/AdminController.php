<?php


namespace App\Http\Controllers;

class AdminController extends Controller {

    public function home() {
        return view('admin.admin_home');
    }
}
