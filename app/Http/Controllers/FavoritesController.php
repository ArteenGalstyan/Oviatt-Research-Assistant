<?php

namespace App\Http\Controllers;
use App\FavoriteArticles;
use App\WebUtils;
use App\SearchHistory;
use App\Http\Controllers\CitationController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller {

    public function favorites_blade() {
        $favorites_data = FavoriteArticles::get_user_favorites_full(Auth::user()->id);
        return view('favorites.layout', [
            'favorites' => $favorites_data,
            'citation' => CitationController::generate_citation_from_favorites($favorites_data)
        ]);
    }

}
