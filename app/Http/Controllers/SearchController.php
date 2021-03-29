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

    private function get_search_results($query)
    {
        $results = DB::table('oa_data')
            ->whereRaw("UPPER(oa_data.TITLE) LIKE '%" . strtoupper($query) . "%' LIMIT 10")
            ->get();
        $out = [];
        $count = 0;
        foreach ($results as $result) {
            array_push($out, [
                'id' => $result->ID,
                'image' => $this->get_related_image($query, $count++),
                'title' => $result->TITLE,
                'description' => $result->ABSTRACT,
                'source' => 'https://google.com/search?q='.$result->SOURCE,
                'source_title' => $result->SOURCE
            ]);
        }
        return $out;
    }

    private function get_related_image($query, $index) {
        $ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            "https://pixabay.com/api/?key=20903304-d6b87a5a7f557a5a58db0a4fa&q=".$query."&image_type=photo"
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        $out_decoded = json_decode($output);
        $count = 0;
        foreach ($out_decoded->hits as $hit) {
            if ($count == $index) {
                return $hit->largeImageURL;
            }
            $count++;
        }
        return asset('img/csun-icon.png');
    }
}
