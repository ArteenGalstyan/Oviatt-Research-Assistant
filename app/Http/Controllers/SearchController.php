<?php

namespace App\Http\Controllers;
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

        return view('search.layout', [
            'results' => $this->get_search_results(
                Request::get('s')
            )
        ]);
    }

    private function get_search_results($query) {
        /**
         * Just an example for now, but this will serve up the search cards. More
         * fields can be added here as needed in the future
         */

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
