<?php

namespace App\Http\Controllers;
use App\FavoriteArticles;
use App\WebUtils;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller {

    public function get_article() {
        if (!Request::has('id')) {
            return view('articles.layout', [
                'status' => 'error',
                'reason' => 'No ID supplied',
                'data' => null,
            ]);
        }
        if (!$this->article_exists(Request::get('id'))) {
            return view('articles.layout', [
                'status' => 'error',
                'reason' => 'No article exists by ID ' . Request::get('id'),
                'data' => null,
            ]);

        }

        return view('articles.layout', [
            'status' => 'success',
            'reason' => null,
            'data' => $this->fetch_article_data(Request::get('id')),
            'suggested' => $this->fetch_suggested_articles(Request::get('id'))
        ]);
    }


    public function favorite_article() {
        if (!Request::has('id') || !Request::has('user_id')) {
            return $this->api_response('Failed to favorite article. Missing parameters', 400);
        }
        if (FavoriteArticles::favorite_article(
            Request::get('id'),
            Request::get('user_id')
        )) {
            return $this->api_response('Successfully favorited article', 200);
        }
        else {
            return $this->api_response('Failed to favorite article. Internal error', 500);
        }
    }

    private function article_exists($id) {
        /**
         * Eventually will need to implement this against a dataset. For now, since the dataset
         * isn't real, just return true.
         */
        return true;
    }

    private function fetch_article_data($id) {
        $result = DB::table('oa_data')
            ->where('id', $id)
            ->first();

        return [
            'title' => $result->TITLE,
            'description' => $result->ABSTRACT,
            'isbn' => $result->ISBN,
            'source_title' => $result->SOURCE,
            'source' => 'https://google.com/search?q='.$result->SOURCE,
            'image' => '',
            'keywords' => $result->AUTHOR_SUPPLIED_KEYWORDS,
            'subjects' => $result->SUBJECTS,
            'pub_type' => $result->PUB_TYPE,
            'publisher' => $result->PUBLISHER,
            'year' => $result->PUB_YEAR,
            'issn' => $result->ISSN,
            'isbn' => $result->ISBN,
            'is_favorited' => FavoriteArticles::is_favorited($id, Auth::user() ? Auth::user()->id : 0)
        ];
    }

    private function fetch_suggested_articles($id) {
        $result = DB::table('oa_data')
            ->where('id', $id)
            ->select('group_id')
            ->first();
        $suggested = DB::table('oa_data')
            ->where('group_id', $result->group_id)
            ->limit(3)
            ->inRandomOrder()
            ->get();
        return $suggested->toArray();
    }

}
