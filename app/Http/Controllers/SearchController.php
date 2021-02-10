<?php

namespace App\Http\Controllers;
use App\WebUtils;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller {

    public function search()  {
        return view('search.layout', [
            'results' => $this->get_search_results(
                Request::get('s')
            )
        ]);
    }

    private function get_search_results($query) {
        return [
            [
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
            [
                'image' => asset('img/csun-icon.png'),
                'title' => 'Example Title',
                'description' => 'Example description',
                'source' => 'https://google.com',
                'source_title' => 'Google'
            ],
        ];
    }
}
