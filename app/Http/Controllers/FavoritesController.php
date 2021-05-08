<?php

namespace App\Http\Controllers;
use App\FavoriteArticles;
use App\WebUtils;
use App\SearchHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller {

    public function favorites_blade() {
        return view('favorites.layout', [
            'favorites' => FavoriteArticles::get_user_favorites_full(Auth::user()->id)
        ]);
    }

}
