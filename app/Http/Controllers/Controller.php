<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Jenssegers\Agent\Agent;
use Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $agent;

    public function __construct() {
        $this->agent = new Agent();
    }

    public function api_response($msg, $code) {
        return response()->json([
            'status' => $code == 200 ? 'success' : 'failure',
            'reason' => $msg
        ], $code);
    }
}
