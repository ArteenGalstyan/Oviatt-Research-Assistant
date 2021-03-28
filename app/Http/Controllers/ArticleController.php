<?php

namespace App\Http\Controllers;
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
            'data' => $this->fetch_article_data(Request::get('id'))
        ]);
    }

    private function article_exists($id) {
        /**
         * Eventually will need to implement this against a dataset. For now, since the dataset
         * isn't real, just return true.
         */
        return true;
    }

    private function fetch_article_data($id) {
        $result = DB::connection('oa_data')
            ->table('oa_data')
            ->where('id', $id)
            ->first();

        return [
            'title' => $result->TITLE,
            'description' => $result->ABSTRACT,
            'isbn' => $result->ISBN,
            'source_title' => $result->SOURCE,
            'source' => 'https://google.com/search?q='.$result->SOURCE,
            'image' => asset('img/csun-icon.png'),
        ];
    }
}
