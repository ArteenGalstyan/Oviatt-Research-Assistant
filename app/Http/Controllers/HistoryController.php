<?php

namespace App\Http\Controllers;
use App\WebUtils;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller {

    public function history_blade() {
        return view('history.layout');
    }

    private function get_user_history($user_id) {
    }

}
