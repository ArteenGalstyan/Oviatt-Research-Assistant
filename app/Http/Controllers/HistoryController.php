<?php

namespace App\Http\Controllers;
use App\WebUtils;
use App\SearchHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller {

    public function history_blade() {
        return view('history.layout', [
            'queries' => SearchHistory::get_user_history(Auth::user()->id)
        ]);
    }

    public function delete_history() {
        if (!Request::has('id')) {
            return $this->api_response('Please supply query history ID', 400);
        }
        SearchHistory::delete_query_history(Request::get('id'));
    }
}
