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

    public static function generate_citation_from_favorites($favorites_data)
    {
        $out = "";
        $title = array_column($favorites_data, 'TITLE');
        array_multisort($title, SORT_ASC, $favorites_data);
        foreach ($favorites_data as $favorite) {
            $out .= "
\"$favorite->TITLE\"
&#9;<i>$favorite->PUBLISHER</i>, $favorite->SOURCE, $favorite->PUB_YEAR, doi:$favorite->DOI
            ";
        }
        return $out;
    }
}
