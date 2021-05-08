<?php

namespace App\Http\Controllers;
use App\FavoriteArticles;
use App\WebUtils;
use App\SearchHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CitationController extends Controller
{

    public static function generate_citation_from_favorites($user_id, $favorites_data)
    {
        $out = "";
        $
        krsort($favorites_data, SORT_STRING);
        foreach ($favorites_data as $favorite) {
            $out .= "
\"$favorite->TITLE\"
&#9;<i>$favorite->PUBLISHER</i>, $favorite->SOURCE, $favorite->PUB_YEAR, doi:$favorite->DOI
            ";

        }
        return $out;
    }
}
