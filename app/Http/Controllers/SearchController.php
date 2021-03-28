<?php

namespace App\Http\Controllers;
use App\SearchHistory;
use App\WebUtils;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller {

    public function search()  {
        /**
         * Search API entry point. Serves the blade and activates logic for fetching
         * search results
         */
        if (!Request::get('s')) {
            return view('home.layout');
        }

        SearchHistory::record_user_search(
            Request::get('s'),
            Auth::user() ? Auth::user()->id : -1
        );

        return view('search.layout', [
            'results' => $this->get_search_results(
                Request::get('s')
            )
        ]);
    }

    private function get_search_results($query) {
        $results = DB::connection('oa_data')
            ->table('oa_data')
            ->whereRaw("UPPER(oa_data.TITLE) LIKE '%". strtoupper($query)."%'")
            ->get();
        $out = [];
        foreach ($results as $result) {
            array_push($out, [
                'id' => $result->ID,
                'image' => asset('img/csun-icon.png'),
                'title' => $result->TITLE,
                'description' => $result->ABSTRACT,
                'source' => 'https://google.com',
                'source_title' => $result->SOURCE
            ]);
        }
        return $out;
        return [
            [
                'id' => 12345,
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'id' => 12345,
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'id' => 12345,
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'id' => 12345,
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'id' => 12345,
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'id' => 12345,
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
        ];
    }
}
